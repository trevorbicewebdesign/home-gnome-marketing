<?php
/**
 * Plan comparison: the Plans records as core Columns of cards.
 *
 * Rendering rules from docs/design/plans-and-model.md: free_forever reads "Free, forever",
 * unannounced reads "Price to be announced" (never $0), an announced subscription leads with its
 * yearly price ("$50 a year", then "or $5 a month"), a founding offer carries a written "Founding
 * households" label, a proposed app inclusion carries a written "Proposed" label, a planned record
 * never produces a store button, and every status is written out.
 *
 * @package home-gnome
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True in the editor.
 */

declare( strict_types=1 );

namespace HomeGnome\Blocks;

require_once dirname( __DIR__ ) . '/markup.php';

$which  = get_field( 'plans' ) ?: 'all';
$detail = get_field( 'detail' ) ?: 'full';

$query = array(
	'post_type'      => 'hg_plan',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'meta_key'       => 'display_order',
	'orderby'        => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
	'no_found_rows'  => true,
);
if ( 'hosting' === $which ) {
	$query['meta_query'] = array( array( 'key' => 'record_type', 'value' => 'hosting' ) );
}
$plans = get_posts( $query );

if ( ! $plans ) {
	echo do_blocks( empty_notice( __( 'No plans yet: add Plan records to fill this comparison.', 'home-gnome' ), $is_preview ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$status_labels = array(
	'available' => array( __( 'Available', 'home-gnome' ), 'tertiary' ),
	'coming'    => array( __( 'Coming', 'home-gnome' ), 'quaternary' ),
	'planned'   => array( __( 'Planned', 'home-gnome' ), 'quaternary' ),
);
$intervals     = array(
	'monthly' => __( 'monthly', 'home-gnome' ),
	'yearly'  => __( 'yearly', 'home-gnome' ),
);

// "$50" for US dollars, "50 EUR" otherwise; cents only when there are any.
$money = static function ( $amount, string $currency ): string {
	$amount   = (float) $amount;
	$number   = number_format_i18n( $amount, floor( $amount ) === $amount ? 0 : 2 );
	$currency = strtoupper( trim( $currency ) );
	return ( '' === $currency || 'USD' === $currency ) ? '$' . $number : $number . ' ' . $currency;
};

$small_neutral = array( 'textColor' => 'neutral', 'fontSize' => 'small' );
$columns       = '';

foreach ( $plans as $plan ) {
	$id     = $plan->ID;
	$status = (string) get_field( 'status', $id );
	$inner  = '';

	[ $label, $background ] = $status_labels[ $status ] ?? array( ucfirst( $status ), 'tertiary' );
	$inner                 .= status_label( $label, $background );

	$inner .= heading( text( get_the_title( $plan ) ), 3, array( 'style' => array( 'spacing' => array( 'margin' => array( 'top' => 'var:preset|spacing|xx-small' ) ) ) ) );

	$summary = (string) get_field( 'summary', $id );
	if ( $summary ) {
		$inner .= paragraph( text( $summary ), $small_neutral );
	}

	// The price line: a status, never an invented amount.
	$billing  = (string) get_field( 'billing_model', $id );
	$currency = (string) get_field( 'currency', $id );
	$monthly  = '';
	switch ( get_field( 'price_status', $id ) ) {
		case 'free_forever':
			$price = __( 'Free, forever', 'home-gnome' );
			break;
		case 'announced':
			$amount = get_field( 'price_amount', $id );
			if ( null === $amount || '' === $amount ) {
				$price = __( 'Price to be announced', 'home-gnome' );
			} elseif ( 'subscription' === $billing ) {
				/* translators: %s: the yearly price, e.g. $50 */
				$price = sprintf( __( '%s a year', 'home-gnome' ), $money( $amount, $currency ) );
				$per_month = get_field( 'price_monthly', $id );
				if ( null !== $per_month && '' !== $per_month ) {
					/* translators: %s: the monthly price, e.g. $5 */
					$monthly = sprintf( __( 'or %s a month', 'home-gnome' ), $money( $per_month, $currency ) );
				}
			} else {
				$price = $money( $amount, $currency );
			}
			break;
		default:
			$price = __( 'Price to be announced', 'home-gnome' );
	}
	$inner .= paragraph(
		text( $price ),
		array(
			'textColor' => 'heading',
			'fontSize'  => 'large',
			'style'     => array(
				'typography' => array( 'fontWeight' => '700', 'lineHeight' => '1.3' ),
				'spacing'    => array( 'margin' => array( 'top' => 'var:preset|spacing|x-small' ) ),
			),
		)
	);

	$note = $monthly ?: (string) get_field( 'price_note', $id );
	if ( 'subscription' === $billing && ! $note ) {
		$chosen = array_intersect_key( $intervals, array_flip( (array) get_field( 'billing_intervals', $id ) ) );
		$note   = $chosen ? ucfirst( implode( __( ' or ', 'home-gnome' ), $chosen ) ) . __( ' subscription', 'home-gnome' ) : '';
	}
	if ( $note ) {
		$inner .= paragraph( text( $note ), array( 'textColor' => 'neutral', 'fontSize' => 'x-small', 'style' => array( 'spacing' => array( 'margin' => array( 'top' => '0' ) ) ) ) );
	}

	// A founding offer: a written label, and only once the price is announced.
	$offer = (string) get_field( 'founding_offer', $id );
	if ( $offer && 'announced' === get_field( 'price_status', $id ) ) {
		$inner .= group(
			status_label( __( 'Founding households', 'home-gnome' ), 'tertiary' ) . paragraph( text( $offer ), array( 'fontSize' => 'small' ) ),
			array(
				'style'  => array( 'spacing' => array( 'blockGap' => 'var:preset|spacing|xxx-small' ) ),
				'layout' => array( 'type' => 'default' ),
			)
		);
	}

	$highlights = array_filter( array_column( (array) get_field( 'highlights', $id ), 'highlight' ) );
	if ( 'full' === $detail ) {
		$highlights = array_merge( $highlights, array_filter( array_column( (array) get_field( 'operational_inclusions', $id ), 'inclusion' ) ) );
	}
	if ( $highlights ) {
		$inner .= bullet_list( $highlights, array( 'fontSize' => 'small' ) );
	}

	if ( 'full' === $detail ) {
		$operation = (string) get_field( 'operation', $id );
		if ( $operation ) {
			$inner .= paragraph( text( $operation ), $small_neutral );
		}
		$address = (string) get_field( 'address_example', $id );
		if ( $address ) {
			/* translators: %s: an example address, e.g. yourhouse.homegnome */
			$inner .= paragraph( sprintf( esc_html__( 'A %s address (illustrative).', 'home-gnome' ), '<code>' . text( $address ) . '</code>' ), $small_neutral );
		}
	}

	// The native app line: "Proposed" is a written label, never a promise.
	$app_note = (string) get_field( 'app_inclusion_note', $id );
	if ( $app_note ) {
		if ( 'proposed_included' === get_field( 'includes_app', $id ) ) {
			$inner .= group(
				status_label( __( 'Proposed', 'home-gnome' ), 'quaternary' ) . paragraph( text( $app_note ), array( 'fontSize' => 'small' ) ),
				array(
					'style'  => array( 'spacing' => array( 'blockGap' => 'var:preset|spacing|xxx-small' ) ),
					'layout' => array( 'type' => 'default' ),
				)
			);
		} else {
			$inner .= paragraph( text( $app_note ), $small_neutral );
		}
	}

	$cta_label = (string) get_field( 'cta_label', $id );
	$cta_url   = (string) get_field( 'cta_url', $id );
	if ( $cta_label && $cta_url ) {
		$inner .= group(
			button( $cta_label, home_url( $cta_url ) ),
			array(
				'style'  => array( 'spacing' => array( 'margin' => array( 'top' => 'auto' ), 'padding' => array( 'top' => 'var:preset|spacing|xx-small' ) ) ),
				'layout' => array( 'type' => 'default' ),
			)
		);
	}

	$columns .= block(
		'column',
		array(),
		"<div class=\"wp-block-column\">\n" . card(
			$inner,
			array( 'layout' => array( 'type' => 'flex', 'orientation' => 'vertical', 'justifyContent' => 'stretch' ) )
		) . '</div>'
	);
}

$wrapper = array(
	'align' => $block['align'] ?? '',
	'style' => array( 'spacing' => array( 'blockGap' => array( 'top' => 'var:preset|spacing|small', 'left' => 'var:preset|spacing|small' ) ) ),
);
$classes = array( 'wp-block-columns', 'home-gnome-plan-comparison' );
if ( ! empty( $wrapper['align'] ) ) {
	$classes[] = 'align' . $wrapper['align'];
} else {
	unset( $wrapper['align'] );
}
if ( ! empty( $block['anchor'] ) ) {
	$anchor = ' id="' . esc_attr( $block['anchor'] ) . '"';
} else {
	$anchor = '';
}

echo do_blocks( block( 'columns', $wrapper, '<div class="' . esc_attr( implode( ' ', $classes ) ) . "\"{$anchor}>\n{$columns}</div>" ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
