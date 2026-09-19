<?php
/**
 * Automatic updates from GitHub Releases.
 *
 * Every push to the main branch is packaged by GitHub Actions as a release.
 * This updater exposes that release to WordPress and opts this theme into
 * background automatic updates.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MYSALARY_GITHUB_REPOSITORY', 'pmunankarmi/mysalary' );
define( 'MYSALARY_GITHUB_API_URL', 'https://api.github.com/repos/' . MYSALARY_GITHUB_REPOSITORY );

/**
 * Fetch and cache the latest GitHub release.
 *
 * @return array|WP_Error
 */
function mysalary_github_latest_release() {
	$cache_key = 'mysalary_github_release_' . md5( MYSALARY_GITHUB_REPOSITORY );
	$cached    = get_site_transient( $cache_key );

	if ( is_array( $cached ) && ! empty( $cached['tag_name'] ) ) {
		return $cached;
	}

	$response = wp_remote_get(
		MYSALARY_GITHUB_API_URL . '/releases/latest',
		[
			'timeout' => 15,
			'headers' => [
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'MySalary-WordPress-Theme/' . MYSALARY_VERSION,
				'X-GitHub-Api-Version' => '2022-11-28',
			],
		]
	);

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$status = (int) wp_remote_retrieve_response_code( $response );
	$data   = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( 200 !== $status || ! is_array( $data ) || empty( $data['tag_name'] ) ) {
		return new WP_Error( 'mysalary_github_release_unavailable', __( 'The MySalary update service is temporarily unavailable.', 'mysalary' ) );
	}

	set_site_transient( $cache_key, $data, HOUR_IN_SECONDS );
	return $data;
}

/** Find the installable mysalary.zip asset from a release. */
function mysalary_github_release_package( $release ) {
	if ( ! empty( $release['assets'] ) && is_array( $release['assets'] ) ) {
		foreach ( $release['assets'] as $asset ) {
			if ( ! empty( $asset['name'] ) && 'mysalary.zip' === $asset['name'] && ! empty( $asset['browser_download_url'] ) ) {
				return esc_url_raw( $asset['browser_download_url'] );
			}
		}
	}

	return '';
}

/** Add the latest release to WordPress's theme update data. */
add_filter( 'pre_set_site_transient_update_themes', function ( $transient ) {
	if ( ! is_object( $transient ) ) {
		$transient = new stdClass();
	}

	$theme = wp_get_theme( get_template() );
	if ( ! $theme->exists() ) {
		return $transient;
	}

	$release = mysalary_github_latest_release();
	if ( is_wp_error( $release ) ) {
		return $transient;
	}

	$latest_version = ltrim( sanitize_text_field( $release['tag_name'] ), 'vV' );
	$package        = mysalary_github_release_package( $release );
	$stylesheet     = $theme->get_stylesheet();

	if ( ! $package || ! preg_match( '/^\d+(?:\.\d+)+$/', $latest_version ) ) {
		return $transient;
	}

	if ( version_compare( $latest_version, $theme->get( 'Version' ), '>' ) ) {
		$transient->response[ $stylesheet ] = [
			'theme'       => $stylesheet,
			'new_version' => $latest_version,
			'url'         => ! empty( $release['html_url'] ) ? esc_url_raw( $release['html_url'] ) : 'https://github.com/' . MYSALARY_GITHUB_REPOSITORY,
			'package'     => $package,
			'requires'    => '6.0',
			'requires_php'=> '7.4',
		];
	} else {
		unset( $transient->response[ $stylesheet ] );
		$transient->no_update[ $stylesheet ] = [
			'theme'       => $stylesheet,
			'new_version' => $theme->get( 'Version' ),
			'url'         => 'https://github.com/' . MYSALARY_GITHUB_REPOSITORY,
			'package'     => '',
		];
	}

	return $transient;
} );

/** Ensure this theme is installed automatically when an update is available. */
add_filter( 'auto_update_theme', function ( $update, $item ) {
	$stylesheet = wp_get_theme( get_template() )->get_stylesheet();
	$item_theme = '';

	if ( is_object( $item ) ) {
		$item_theme = isset( $item->theme ) ? $item->theme : ( isset( $item->stylesheet ) ? $item->stylesheet : '' );
	} elseif ( is_array( $item ) ) {
		$item_theme = isset( $item['theme'] ) ? $item['theme'] : ( isset( $item['stylesheet'] ) ? $item['stylesheet'] : '' );
	}

	return $stylesheet === $item_theme ? true : $update;
}, 10, 2 );

/**
 * GitHub release archives use a versioned directory. Rename it to the stable
 * theme slug so WordPress upgrades the existing theme instead of adding one.
 */
add_filter( 'upgrader_source_selection', function ( $source, $remote_source, $upgrader, $hook_extra ) {
	if ( empty( $hook_extra['theme'] ) || get_template() !== $hook_extra['theme'] ) {
		return $source;
	}

	global $wp_filesystem;
	$desired_source = trailingslashit( $remote_source ) . get_template() . '/';

	if ( trailingslashit( $source ) === $desired_source ) {
		return $source;
	}

	if ( $wp_filesystem->exists( $desired_source ) ) {
		$wp_filesystem->delete( $desired_source, true );
	}

	if ( ! $wp_filesystem->move( $source, $desired_source, true ) ) {
		return new WP_Error( 'mysalary_update_source', __( 'WordPress could not prepare the MySalary theme update.', 'mysalary' ) );
	}

	return $desired_source;
}, 10, 4 );

/** Clear cached release metadata after a theme update. */
add_action( 'upgrader_process_complete', function ( $upgrader, $options ) {
	if ( 'theme' !== ( $options['type'] ?? '' ) || 'update' !== ( $options['action'] ?? '' ) ) {
		return;
	}

	delete_site_transient( 'mysalary_github_release_' . md5( MYSALARY_GITHUB_REPOSITORY ) );
	delete_site_transient( 'update_themes' );
}, 10, 2 );

/** Check GitHub hourly; WordPress's automatic updater installs any release. */
add_action( 'init', function () {
	if ( ! wp_next_scheduled( 'mysalary_github_update_check' ) ) {
		wp_schedule_event( time() + MINUTE_IN_SECONDS, 'hourly', 'mysalary_github_update_check' );
	}
} );

add_action( 'mysalary_github_update_check', function () {
	delete_site_transient( 'mysalary_github_release_' . md5( MYSALARY_GITHUB_REPOSITORY ) );
	delete_site_transient( 'update_themes' );
	wp_update_themes();

	if ( ! wp_next_scheduled( 'wp_maybe_auto_update' ) ) {
		wp_schedule_single_event( time() + MINUTE_IN_SECONDS, 'wp_maybe_auto_update' );
	}
} );

