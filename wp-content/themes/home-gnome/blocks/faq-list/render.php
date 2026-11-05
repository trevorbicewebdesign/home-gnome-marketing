<?php
/**
 * FAQ list: the FAQ records as core Details blocks, all closed by default.
 *
 * @package home-gnome
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True in the editor.
 */

declare( strict_types=1 );

namespace HomeGnome\Blocks;

require_once dirname( __DIR__ ) . '/markup.php';

$show_on = get_field( 'show_on' ) ?: 'faq';
$limit   = (int) get_field( 'limit' );

$query = array(
	'post_type'      => 'hg_faq',
	'post_status'    => 'publish',
	'posts_per_page' => $limit > 0 ? $limit : 50,
	'meta_key'       => 'display_order',
	'orderby'        => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
	'no_found_rows'  => true,
);
if ( 'all' !== $show_on ) {
	// The checkbox is stored serialised; match the quoted value.
	$query['meta_query'] = array(
		array(
			'key'     => 'show_on',
			'value'   => '"' . $show_on . '"',
			'compare' => 'LIKE',
		),
	);
}
$faqs = get_posts( $query );

if ( ! $faqs ) {
	echo do_blocks( empty_notice( __( 'No questions yet: add FAQ records and tick where they show.', 'home-gnome' ), $is_preview ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$items = '';
foreach ( $faqs as $faq ) {
	$answer = paragraph( text( (string) get_field( 'answer', $faq->ID ) ) );
	$items .= block(
		'details',
		array(),
		'<details class="wp-block-details"><summary>' . text( get_the_title( $faq ) ) . "</summary>\n{$answer}</details>"
	);
}

$attrs = array(
	'style'  => array( 'spacing' => array( 'blockGap' => 'var:preset|spacing|xx-small' ) ),
	'layout' => array( 'type' => 'default' ),
);
$markup = group( $items, $attrs );
if ( ! empty( $block['anchor'] ) ) {
	$markup = preg_replace( '/<div class="wp-block-group/', '<div id="' . esc_attr( $block['anchor'] ) . '" class="wp-block-group', $markup, 1 );
}

echo do_blocks( $markup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
