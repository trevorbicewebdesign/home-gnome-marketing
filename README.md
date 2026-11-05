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
composer install        # plugins, parent theme, core
wp theme activate home-gnome
```

The theme is edited in the Site Editor and exported back into `wp-content/themes/home-gnome` with
Create Block Theme, or edited by hand: `theme.json` for colours, type and spacing, `patterns/` for
sections, `templates/` and `parts/` for page structure, `acf-json/` for ACF field groups (ACF
reads and writes them there). Forms are Gravity Forms, exported to `docs/forms/` when they change.

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
