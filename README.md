# Home Gnome marketing site

The WordPress site that sells [Home Gnome](https://github.com/trevorbicewebdesign/home-gnome), the
self-hosted household inventory server. This repository is the site's web root minus WordPress core,
minus every third-party plugin and theme, and minus production data: Composer brings the first two,
and the third stays on the server.

| Part | Where it comes from |
| --- | --- |
| WordPress core | `roots/wordpress-no-content` via Composer; `bin/install-core.php` copies it into the web root after every `composer install` |
| Spectra One (parent theme), Spectra, Create Block Theme, Query Monitor (dev) | wpackagist via Composer |
| ACF Pro, Gravity Forms, Akeeba Backup | the owner's private Composer mirrors (`trevorbicewebdesign/*`, HTTPS with a GitHub token in `auth.json`) |
| `wp-content/themes/home-gnome` | **this repository**: the site's own block theme, a child of Spectra One |
| `wp-config.php` | tracked, secret-free; `wp-config-local.php` (git-ignored) holds the database, URL and salts |
| uploads, caches, backups | production data, never in git and never touched by a deploy |

## Develop

The site runs in Local by Flywheel as `home-gnome-marketing` (<http://home-gnome-marketing.local>),
with this folder as `app/public`. Local's `.envrc` (one level up) puts its PHP 8.4, Composer and
`wp` on the PATH.

```sh
source ../.envrc
composer install                 # plugins, parent theme, core
wp theme activate home-gnome
wp eval-file bin/seed-site.php   # pages, front page, plans, FAQs, features, integrations, forms
```

`bin/seed-site.php` is safe to run again: it matches everything by slug or title and updates it in
place. On an empty Gravity Forms install it imports the five forms from `docs/forms/` as IDs 1-5,
the IDs the patterns place them by (1 Hosted waitlist, 2 Native app notifications, 3 Product
updates, 4 Contact, 5 Newsletter); it warns if a form ends up with another ID. For a theme you
are editing, `define( 'WP_DEVELOPMENT_MODE', 'theme' );` in `wp-config-local.php` stops WordPress
caching the pattern list and theme.json between requests.

### How the theme is put together

| Where | What |
| --- | --- |
| `theme.json`, `styles/button-*.json` | every colour, font, size, spacing step, radius and button treatment; the coral and on-dark button styles are theme.json partials, so there is no custom CSS |
| `assets/fonts/` | Manrope and DM Sans (variable woff2, OFL), served from the theme |
| `parts/header.html`, `parts/footer.html` | the header and footer patterns, built from core Group, Columns, Navigation and Site Title |
| `templates/` | `front-page.html` and `page.html`: header, the page's content in `<main>`, footer |
| `patterns/` | every section: the homepage sections, the Plans and Docs sections, one body per page (`page-*.php`), each a Spectra Container with core blocks inside |
| `blocks/` | three ACF blocks (`feature-list`, `plan-comparison`, `faq-list`) whose PHP templates render the shared records as core blocks |
| `acf-json/` | the post types (`hg_feature`, `hg_integration`, `hg_plan`, `hg_faq`, `hg_release`) and field groups, as ACF local JSON |
| `functions.php` | registers the three blocks and the pattern categories, nothing else |

Each page's content is a list of patterns at the top level (the seed script writes it). Keep it
that way when editing: Spectra generates a Container's CSS only for blocks it finds in post
content, in a template's top level or in a database-saved template part. It does not follow a
pattern nested inside another block, nor a template part that exists only as a theme file, which
is why the header and footer use core blocks.

Plans, prices, FAQs, features and integrations are records (Plans, FAQs, Features, Integrations
in wp-admin), not text in the pages; the blocks select them by type and display order, never by
post ID. A plan's price shows as a status ("Free, forever", "Price to be announced") until a
price is announced.

While the free download is not public, the main action is **Get early access** (header, hero,
closing CTA, the Self-hosted plan's CTA). When it is, change those four to **Download free**.

The Docs page lives at `/documentation/`: `/docs/` is this repository's own folder in the web root
locally (production does not deploy it).

Forms are Gravity Forms with the Orbital theme, styled through the Gravity Forms block's own
settings. After changing one, export it (Forms → Import/Export → Export Forms) and save it over its
file in `docs/forms/`.

## Design

The design brief, site map and chosen visual direction are in [docs/design/](docs/design/).

## Deploy

The NAS deploys this repository with `deploy_site.sh` from
[tbwebdesign-server-infrastructure](https://github.com/trevorbicewebdesign/tbwebdesign-server-infrastructure)
(site conf `home-gnome-marketing`, repo mapped onto `public`, plugins and themes synced with
`--delete`). `.deployignore` keeps the dev tooling and the production-owned files out of the sync;
`.deploykeep` protects what Akeeba Backup writes inside its own folder. `.github/workflows/deploy.yml`
is the infrastructure repo's template, unchanged: it asks the NAS to deploy one exact commit of the
default branch, behind the Production environment's required reviewer.
