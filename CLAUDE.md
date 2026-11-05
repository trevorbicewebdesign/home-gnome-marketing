# Home Gnome marketing site

- The repository is the web root (`app/public` of the Local site `home-gnome-marketing`) minus core,
  third-party code and production data. `composer.json` installs core (copied in by
  `bin/install-core.php`), the plugins and the parent theme; `.gitignore` allow-lists only
  `wp-content/themes/home-gnome` and `wp-content/mu-plugins`. Do not commit anything under
  `wp-content/plugins`, `wp-content/themes/spectra-one`, `vendor/`, `wp-admin/` or `wp-includes/`.
- **The repository is public.** `wp-config.php` is tracked and must stay secret-free; the database,
  URL and salts live in `wp-config-local.php` (git-ignored). Never commit a key, token, salt,
  licence key or `auth.json`.
- The site's own code is the block theme `wp-content/themes/home-gnome` (child of Spectra One):
  `theme.json` tokens, `patterns/`, `templates/`, `parts/`, `acf-json/`. Build with Spectra One's and Spectra's native blocks, block styles and
  theme.json tokens; custom CSS is a last resort, and when native blocks cannot express something,
  write a custom block (ACF block with block.json and a PHP render template) rather than CSS
  hacks. No page builder, no JS framework. Every form is Gravity Forms.
- Local tooling: `source ../.envrc` (Local's PHP 8.4, Composer, `wp`). The Local database is the
  developer's; changing content or settings there is fine, dropping it is not.
- Deploys go through tbwebdesign-server-infrastructure (`deploy_site.sh`); `.deployignore` and
  `.deploykeep` are read by it. Keep `.github/workflows/deploy.yml` identical to that repo's template.
- Work on a branch and open a PR; never push `main`.
