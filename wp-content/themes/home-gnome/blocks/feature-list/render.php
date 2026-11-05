<?php
/**
 * Feature list: feature or integration records as a grid of core Group cards.
 *
 * The grid is a core Group with grid layout and a minimum column width, so it goes from three
 * columns to two to one as the space narrows, with no breakpoints of its own.
 *
 * @package home-gnome
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True in the editor.
 */

declare( strict_types=1 );

namespace HomeGnome\Blocks;

require_once dirname( __DIR__ ) . '/markup.php';

$source       = 'hg_integration' === get_field( 'source' ) ? 'hg_integration' : 'hg_feature';
$area         = (string) get_field( 'area' );
$columns      = '2' === (string) get_field( 'columns' ) ? 2 : 3;
$show_details = (bool) get_field( 'show_details' );

$query = array(
	'post_type'      => $source,
	'post_status'    => 'publish',
	'posts_per_page' => 24,
	'meta_key'       => 'display_order',
	'orderby'        => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
	'no_found_rows'  => true,
);
if ( 'hg_feature' === $source && $area ) {
	$query['meta_query'] = array( array( 'key' => 'feature_area', 'value' => $area ) );
}
$records = get_posts( $query );

if ( ! $records ) {
	echo do_blocks( empty_notice( __( 'No records yet: add Features or Integrations to fill this list.', 'home-gnome' ), $is_preview ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$availability_labels = array(
	'preview' => __( 'Preview', 'home-gnome' ),
	'planned' => __( 'Planned', 'home-gnome' ),
);

$cards = '';
foreach ( $records as $record ) {
	$id    = $record->ID;
	$inner = '';

	$icon = (int) get_field( 'icon', $id );
	if ( $icon ) {
		$src    = wp_get_attachment_image_url( $icon, 'thumbnail' );
		$inner .= block(
			'image',
			array( 'id' => $icon, 'width' => '32px', 'height' => '32px', 'sizeSlug' => 'thumbnail', 'linkDestination' => 'none', 'style' => array( 'border' => array( 'radius' => '0px' ) ) ),
			'<figure class="wp-block-image size-thumbnail is-resized has-custom-border"><img src="' . esc_url( (string) $src ) . '" alt="" class="wp-image-' . $icon . '" style="border-radius:0px;width:32px;height:32px"/></figure>'
		);
	}

	$availability = (string) get_field( 'availability', $id );
	if ( isset( $availability_labels[ $availability ] ) ) {
		$inner .= status_label( $availability_labels[ $availability ], 'quaternary' );
	}

	$title  = 'hg_feature' === $source ? ( get_field( 'short_title', $id ) ?: get_the_title( $record ) ) : get_the_title( $record );
	$inner .= heading( text( (string) $title ), 3, array( 'fontSize' => 'large', 'style' => array( 'typography' => array( 'lineHeight' => '1.3' ) ) ) );

	$summary = (string) get_field( 'summary', $id );
	if ( $summary ) {
		$inner .= paragraph( text( $summary ), array( 'fontSize' => 'small' ) );
	}

	if ( $show_details ) {
		$points = 'hg_feature' === $source
			? array_column( (array) get_field( 'benefits', $id ), 'benefit' )
			: array_column( (array) get_field( 'capabilities', $id ), 'capability' );
		$points = array_filter( $points );
		if ( $points ) {
			$inner .= bullet_list( $points, array( 'fontSize' => 'small' ) );
		}

		if ( 'hg_integration' === $source ) {
			$requirements = array_filter( array_column( (array) get_field( 'requirements', $id ), 'requirement' ) );
			if ( $requirements ) {
				$inner .= paragraph( '<strong>' . esc_html__( 'Requirements', 'home-gnome' ) . '</strong>', array( 'fontSize' => 'small', 'textColor' => 'heading' ) );
				$inner .= bullet_list( $requirements, array( 'fontSize' => 'small' ) );
			}
			$notes = (string) get_field( 'external_service_notes', $id );
			if ( $notes ) {
				$inner .= paragraph( text( $notes ), array( 'fontSize' => 'x-small', 'textColor' => 'neutral' ) );
			}
		}
	}

	$link = 'hg_feature' === $source ? get_field( 'documentation_link', $id ) : null;
	if ( is_array( $link ) && ! empty( $link['url'] ) ) {
		$inner .= paragraph( '<a href="' . esc_url( $link['url'] ) . '">' . text( $link['title'] ?: __( 'Read the guide', 'home-gnome' ) ) . '</a>', array( 'fontSize' => 'small' ) );
	} elseif ( 'hg_integration' === $source && get_field( 'setup_url', $id ) ) {
		$inner .= paragraph( '<a href="' . esc_url( home_url( (string) get_field( 'setup_url', $id ) ) ) . '">' . esc_html__( 'Read the setup guide', 'home-gnome' ) . '</a>', array( 'fontSize' => 'small' ) );
	}

	$cards .= card( $inner );
}

$attrs = array(
	'style'  => array( 'spacing' => array( 'blockGap' => 'var:preset|spacing|small' ) ),
	'layout' => array(
		'type'               => 'grid',
		'columnCount'        => $columns,
		'minimumColumnWidth' => 2 === $columns ? '20rem' : '16rem',
	),
);
if ( ! empty( $block['align'] ) ) {
	$attrs['align']     = $block['align'];
	$attrs['className'] = 'align' . $block['align'];
}
$markup = group( $cards, $attrs );
if ( ! empty( $block['anchor'] ) ) {
	$markup = preg_replace( '/<div class="wp-block-group/', '<div id="' . esc_attr( $block['anchor'] ) . '" class="wp-block-group', $markup, 1 );
}

echo do_blocks( $markup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
