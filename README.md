# MySalary — Bilingual WordPress Theme

A production WordPress conversion of the MySalary marketing site (English / العربية), built around **ACF Pro** for editable content and **Polylang** (free) for translation. Demo, Contact, and Careers include server-validated AJAX forms with a unified admin submissions screen.

## What's in the box

```
mysalary/
├── style.css                          ← theme header (required by WP)
├── functions.php                      ← bootstrap + includes
├── front-page.php                     ← composes the eight home sections
├── header.php / footer.php
├── page.php / index.php / 404.php
├── page-templates/
│   ├── template-about.php
│   ├── template-careers.php
│   ├── template-contact.php
│   └── template-demo.php              ← Request a Demo
├── template-parts/
│   └── front/
│       ├── hero.php
│       ├── solution.php
│       ├── how-it-works.php
│       ├── benefits.php
│       ├── differentiation.php
│       ├── trust.php
│       ├── faq.php
│       └── final-cta.php
├── inc/
│   ├── setup.php                      ← theme supports, menus, image sizes
│   ├── enqueue.php                    ← Cairo + Inter, CSS, JS, RTL font binding
│   ├── acf-fields.php                 ← all field groups (PHP-registered)
│   ├── polylang.php                   ← string registration for translation
│   ├── form-handler.php               ← AJAX form, admin records, email, CSV export
│   └── template-tags.php              ← helpers + inline SVG icon library
├── assets/
│   ├── css/main.css                   ← original stylesheet + demo-page CSS + theme additions
│   ├── js/main.js                     ← hero rotation, reveals, header behaviour
│   ├── js/forms.js                    ← AJAX behaviour for all three forms
│   └── images/                        ← logos and app-store badges
└── languages/                         ← drop .po/.mo files here
```

## Requirements

- **WordPress 6.0+**, **PHP 7.4+**
- **Advanced Custom Fields Pro** — for repeaters, gallery, options pages used by every section. (Free ACF works for simple text fields but you'll lose the repeater-driven lists.)
- **Polylang** (free) — for English ↔ Arabic translation. Polylang Pro is **not** required.

## Automatic updates

The theme checks the latest release from `pmunankarmi/mysalary` every hour. Every push to the repository's `main` branch is packaged and published automatically by GitHub Actions. WordPress then installs the release in the background through its native automatic updater; an administrator does not need to click an update button.

Automatic updates require working WP-Cron and outbound HTTPS access to `api.github.com` and `github.com`. Keep the repository public unless the updater is extended with a private-repository token.

Optional: **ACF Options For Polylang** plugin — only needed if you want the *Site Settings* options page (under "Site Settings" in admin sidebar) to have separate values per language. The home page sections work fine without it because ACF fields on translated pages are already per-language.

## Install

### 1. Upload the theme

**Via WP admin:** Appearance → Themes → Add New → Upload Theme → pick `mysalary.zip` → Install → **don't activate yet**.

**Via cPanel File Manager / FTP:** unzip into `wp-content/themes/mysalary/`.

### 2. Install plugins

1. **ACF Pro** — Plugins → Add New → Upload Plugin → upload your `advanced-custom-fields-pro.zip` from advancedcustomfields.com → Install → Activate. Then ACF → Updates → enter your license.
2. **Polylang** — Plugins → Add New → search "Polylang" → Install → Activate.

### 3. Activate the theme

Appearance → Themes → Activate **MySalary**.

You'll see a yellow notice at the top of the admin if either plugin is missing — install them first.

### 4. Configure Polylang (one-time)

1. WP admin → **Languages → Languages**.
2. Add **English** (slug: `en`, order: 0). Make it the default.
3. Add **Arabic** (slug: `ar`, RTL: yes, order: 1).
4. Languages → Settings → URL modifications: pick "The language is set from the directory name in pretty permalinks" (gives clean `/en/` and `/ar/` URLs). Save.
5. Languages → Settings → enable **String translations** module if it isn't already.

### 5. Set up the home page

1. **Pages → Add New** → title: *Home* → publish (don't add any content; the front-page template ignores it).
2. **Settings → Reading** → Your homepage displays → **A static page** → Homepage: *Home* → Save.
3. Go back to **Pages → Home → Edit**.
4. Below the title, you'll see eight ACF panels — `01 — Hero`, `02 — Solution`, etc. Fill them in (or leave them empty to use the original copy as defaults).
5. Update the page.

### 6. Translate the home page to Arabic

1. Open **Pages → Home → Edit** (English).
2. In the right sidebar there's a Polylang "Languages" panel with a `+` next to Arabic. Click it.
3. WordPress duplicates the page; you fill in the Arabic versions of every ACF field.
4. Publish.

The theme automatically renders Cairo font when the active language is Arabic, and WordPress automatically loads the right-to-left layout (`is-rtl` body class — the theme's CSS handles arrow-icon flipping).

### 7. Translate site-wide strings

WP admin → **Languages → String Translations** → filter by group "MySalary Theme". Form labels and placeholders are registered there. The Career and Contact forms also include built-in Arabic fallbacks, so they never display hardcoded English controls on an Arabic page.

### 8. Set up the Request a Demo page

1. **Pages → Add New** → title: *Request a Demo*.
2. In the page-attribute sidebar, set **Template: Request a Demo**.
3. Publish.
4. Translate it to Arabic via the Polylang sidebar (the form labels come from String Translations, so the Arabic page will pick them up automatically once you translate the strings).
5. Copy the URL into **Site Settings → Demo page URL** (in admin sidebar). The hero "Request a Demo" buttons read this.

### 9. Menus

**Appearance → Menus** — create one menu and assign it to "Primary Navigation" for English; create a separate menu and assign it to "Primary Navigation" for Arabic. Same for the footer menu.

## Editing content

| To edit… | Go to… |
|---|---|
| Headlines, lead paragraphs, bullets, FAQ items, benefit cards, etc. | Pages → Home → Edit (and the Arabic translation) |
| Header navigation fallbacks, footer copy, CTA labels, form labels | Languages → String Translations |
| Logo | Appearance → Customize → Site Identity → Logo |
| Form recipient email, app/play store URLs, Shariah certificate, social links | Site Settings (admin sidebar) |
| Demo, Contact, and Career submissions | Form Submissions (admin sidebar) |

## Customising the design

All colour/typography/spacing tokens live at the top of `assets/css/main.css` under `:root { --ms-purple: ...; --ms-cyan: ...; ... }`. Edit that block to rebrand. The original ~1900-line stylesheet is kept intact below the tokens — every component reads from the variables.

To swap fonts: replace the Google Fonts URL in `inc/enqueue.php` and update `--ms-display` / `--ms-body` in the CSS.

## Adding a new ACF field to a section

Edit `inc/acf-fields.php`, find the relevant group (e.g. `group_hero`), add an entry to its `fields` array. Read it in the matching template part with the helper:

```php
$value = mysalary_field( 'your_field_name', false, 'Default value' );
```

If you'd rather build fields visually: use the ACF GUI, then **ACF → Field Groups → Tools → Generate PHP** and paste the output into `inc/acf-fields.php`.

## Heavy media

This theme zip is intentionally lean — only logos and store badges are bundled. Upload the homepage's large visual assets through the individual ACF image fields instead of placing them in the theme.

These ship as a separate **`mysalary-media-bundle.zip`**. Workflow:

1. WP admin → Media → Add New → drag-and-drop the bundle's contents.
2. Pages → Home → Edit → in the relevant ACF fields, click "Add image / file" and pick the freshly uploaded media:
   - Hero rotating banners → `banner-1.png`, `banner-2.png`, `banner-3.png` (or the .gif versions for animation)
   - Solution visual → `solution-pic.jpeg`
   - How-it-works step illustrations → `family-support.png`, `groceries.png`, `electronics-purchase.png`, `no-borrowing.png`, `offers-n-discounts.png`, `emergency-situation.png`

You only need to do this for English; the Arabic translation can re-use the same media (or have its own — the ACF fields are per-translation).

## Form submissions

Submissions are handled in three ways:

1. **Email** to the address in *Site Settings → Form submissions: send notifications to* (defaults to the WP admin email).
2. **WordPress admin** → Form Submissions lists Demo Requests, Contact Messages, and Career Applications together. Use the form-type dropdown to filter the list.
3. Use the **Export to CSV** button above the list to download all records or only the currently filtered form type. Arabic is exported with a UTF-8 BOM for Excel.

All three forms use a WordPress nonce, a honeypot, server-side validation, and a one-minute hashed rate limit. Career uploads accept PDF, DOC, or DOCX files up to 5 MB. No reCAPTCHA keys or visitor IP addresses are stored.

The AJAX actions are `mysalary_demo_submit`, `mysalary_contact_submit`, and `mysalary_career_submit`.

## RTL & Arabic notes

- Cairo is loaded for both languages but only applied to body/headings when the current Polylang language is `ar`. Inter is used for English.
- `is-rtl` body class is added when the active locale is RTL — the theme's CSS uses this for one specific override (flipping the `→` arrow icon in CTA buttons). Add more selectors as needed.
- WordPress auto-loads `rtl.css` if it exists in the theme root. This theme handles RTL inside `main.css` via the `[dir="rtl"]` selector and `is-rtl` class — there's no separate `rtl.css`. If you find an alignment that needs fixing in Arabic, target it with `body.is-rtl .your-selector { ... }`.

## Troubleshooting

| Symptom | Fix |
|---|---|
| Front page shows the page title and an empty content area | Static front page set, but the theme isn't using `front-page.php`. Re-activate the theme. |
| ACF panels missing on Home page edit screen | ACF Pro not installed/activated; or the page isn't set as the static front page (the field-group location targets the `front_page` page type). |
| All home sections show default English copy even after editing in Arabic | The Arabic page wasn't translated through Polylang's `+` button — the ACF values you edited might be on a separate page. Check Pages → make sure both English and Arabic versions exist and are linked in Polylang. |
| Hero stage shows nothing | No banner images uploaded. Add at least one image in *Pages → Home → 01 Hero → Hero rotating banners*. |
| Form button stuck on "Sending…" | Open browser dev tools → Network → submit → look at the response. Most common cause is a security plugin blocking `admin-ajax.php` — whitelist it. |
| Arabic page renders in Inter, not Cairo | Polylang language slug for Arabic must be exactly `ar`. Check Languages → Languages. |

## License

Theme code: GPL v2 or later. Bundled SVG icons (Feather Icons): MIT.
