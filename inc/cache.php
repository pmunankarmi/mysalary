<?php
/**
 * Cache integration.
 *
 * Theme releases can change rendered HTML while a full-page cache continues
 * serving the previous markup. Purge LiteSpeed once after each installed theme
 * version so automatic GitHub updates become visible without an admin action.
 *
 * @package MySalary
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Purge full-page caches once when the installed theme version changes.
 */
function mysalary_purge_cache_after_version_change() {
	$option_name      = 'mysalary_rendered_cache_version';
	$previous_version = (string) get_option( $option_name, '' );

	if ( MYSALARY_VERSION === $previous_version ) {
		return;
	}

	/**
	 * LiteSpeed Cache supports this public purge action. It is a no-op when the
	 * plugin is not active, so the theme does not need a hard dependency on it.
	 */
	do_action( 'litespeed_purge_all' );

	update_option( $option_name, MYSALARY_VERSION, false );
}
add_action( 'init', 'mysalary_purge_cache_after_version_change', 99 );
