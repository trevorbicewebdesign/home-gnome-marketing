<?php
/**
 * Home Gnome marketing site – WordPress configuration. This file is tracked in git, and the
 * repository is public, so it holds NO secrets: the database, the site URL and the salts come
 * from wp-config-local.php (git-ignored, never deployed) on this machine, and from the NAS's own
 * copy in production (the deploy never overwrites either file; see .deployignore).
 */

if ( file_exists( __DIR__ . '/wp-config-local.php' ) ) {
	require __DIR__ . '/wp-config-local.php';
}

// ── Defaults a CI runner can use (root/root on localhost); every real install overrides them ──
defined( 'DB_NAME' )     || define( 'DB_NAME', 'local' );
defined( 'DB_USER' )     || define( 'DB_USER', 'root' );
defined( 'DB_PASSWORD' ) || define( 'DB_PASSWORD', 'root' );
defined( 'DB_HOST' )     || define( 'DB_HOST', 'localhost' );
defined( 'DB_CHARSET' )  || define( 'DB_CHARSET', 'utf8mb4' );
defined( 'DB_COLLATE' )  || define( 'DB_COLLATE', '' );
$table_prefix = 'wp_';

// Salts: placeholders only. A real install defines all eight in wp-config-local.php
// (https://api.wordpress.org/secret-key/1.1/salt/).
foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT' ) as $hg_salt ) {
	defined( $hg_salt ) || define( $hg_salt, 'put your unique phrase here' );
}
unset( $hg_salt );

// ── Environment ─────────────────────────────────────────────────────────────
defined( 'WP_ENVIRONMENT_TYPE' ) || define( 'WP_ENVIRONMENT_TYPE', 'local' );
defined( 'WP_DEBUG' )            || define( 'WP_DEBUG', WP_ENVIRONMENT_TYPE !== 'production' );
defined( 'WP_DEBUG_LOG' )        || define( 'WP_DEBUG_LOG', WP_DEBUG );
defined( 'WP_DEBUG_DISPLAY' )    || define( 'WP_DEBUG_DISPLAY', false );
defined( 'FS_METHOD' )           || define( 'FS_METHOD', 'direct' );
// Everything is installed by Composer or committed; nothing is edited or updated from wp-admin.
defined( 'DISALLOW_FILE_EDIT' )  || define( 'DISALLOW_FILE_EDIT', true );
defined( 'DISALLOW_FILE_MODS' )  || define( 'DISALLOW_FILE_MODS', WP_ENVIRONMENT_TYPE === 'production' );

/* That's all, stop editing! Happy publishing. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
