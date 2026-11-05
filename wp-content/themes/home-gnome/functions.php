<?php
/**
 * Home Gnome theme: registers the theme's ACF blocks and pattern categories.
 *
 * Colours, fonts (served from assets/fonts/), type, spacing and button styles live in theme.json
 * and styles/; post types and field groups live in acf-json/ (ACF local JSON); sections are
 * patterns under patterns/.
 *
 * @package home-gnome
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The ACF blocks that render shared records (features, plans, FAQs) as core blocks.
 */
add_action(
	'init',
	static function (): void {
		foreach ( array( 'feature-list', 'plan-comparison', 'faq-list' ) as $block ) {
			register_block_type( __DIR__ . '/blocks/' . $block );
		}
	}
);

/**
 * Pattern categories for the homepage sections, the page bodies and the site-wide pieces.
 */
add_action(
	'init',
	static function (): void {
		register_block_pattern_category( 'home-gnome-home', array( 'label' => __( 'Home Gnome: homepage', 'home-gnome' ) ) );
		register_block_pattern_category( 'home-gnome-pages', array( 'label' => __( 'Home Gnome: pages', 'home-gnome' ) ) );
		register_block_pattern_category( 'home-gnome-site', array( 'label' => __( 'Home Gnome: site', 'home-gnome' ) ) );
	}
);
