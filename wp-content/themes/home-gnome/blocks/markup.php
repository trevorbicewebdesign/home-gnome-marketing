<?php
/**
 * Builders for core block markup, shared by the ACF block render templates.
 *
 * The ACF blocks render shared records as real core blocks (Group, Columns, Heading, Paragraph,
 * List, Buttons, Details) and pass the result through do_blocks(), so the normal core block
 * styles, layout support and theme.json tokens apply and no stylesheet of their own is needed.
 *
 * @package home-gnome
 */

declare( strict_types=1 );

namespace HomeGnome\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Serialises one block: comment delimiters around the saved HTML.
 *
 * @param string $name  Block name without the core/ prefix for core blocks.
 * @param array  $attrs Block attributes for the comment.
 * @param string $html  Saved HTML, inner blocks included.
 */
function block( string $name, array $attrs, string $html ): string {
	$json = $attrs ? ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : '';
	return "<!-- wp:{$name}{$json} -->\n{$html}\n<!-- /wp:{$name} -->\n";
}

/**
 * Text rendered into block HTML: escaped, with no markup of its own.
 */
function text( string $value ): string {
	return esc_html( $value );
}

/**
 * Classes for a preset font size, text colour and background colour, matching what the editor saves.
 *
 * @param array $attrs Block attributes using fontSize, textColor, backgroundColor.
 * @return string[]
 */
function preset_classes( array $attrs ): array {
	$classes = array();
	if ( ! empty( $attrs['textColor'] ) ) {
		$classes[] = 'has-' . $attrs['textColor'] . '-color';
		$classes[] = 'has-text-color';
	}
	if ( ! empty( $attrs['backgroundColor'] ) ) {
		$classes[] = 'has-' . $attrs['backgroundColor'] . '-background-color';
		$classes[] = 'has-background';
	}
	if ( ! empty( $attrs['fontSize'] ) ) {
		$classes[] = 'has-' . $attrs['fontSize'] . '-font-size';
	}
	if ( ! empty( $attrs['className'] ) ) {
		$classes[] = $attrs['className'];
	}
	return $classes;
}

/**
 * Inline style for the style attribute's spacing, border and typography values.
 *
 * @param array $style The block's style attribute.
 */
function inline_style( array $style ): string {
	$css = wp_style_engine_get_styles( $style );
	return $css['css'] ?? '';
}

/**
 * Builds the opening tag attributes shared by the simple text blocks.
 *
 * @param string[] $classes Base classes.
 * @param array    $attrs   Block attributes.
 */
function tag_attributes( array $classes, array $attrs ): string {
	$classes = array_filter( array_merge( $classes, preset_classes( $attrs ) ) );
	$out     = $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '';
	$style   = inline_style( $attrs['style'] ?? array() );
	if ( $style ) {
		$out .= ' style="' . esc_attr( $style ) . '"';
	}
	return $out;
}

/**
 * A core Paragraph. $html is already-safe inline markup (use text() for plain strings).
 */
function paragraph( string $html, array $attrs = array() ): string {
	return block( 'paragraph', $attrs, '<p' . tag_attributes( array(), $attrs ) . ">{$html}</p>" );
}

/**
 * A core Heading.
 */
function heading( string $html, int $level = 3, array $attrs = array() ): string {
	if ( 2 !== $level ) {
		$attrs = array( 'level' => $level ) + $attrs;
	}
	return block( 'heading', $attrs, "<h{$level}" . tag_attributes( array( 'wp-block-heading' ), $attrs ) . ">{$html}</h{$level}>" );
}

/**
 * A core List of plain-text items.
 *
 * @param string[] $items Item text.
 */
function bullet_list( array $items, array $attrs = array() ): string {
	$inner = '';
	foreach ( $items as $item ) {
		$inner .= block( 'list-item', array(), '<li>' . text( $item ) . '</li>' );
	}
	return block( 'list', $attrs, '<ul' . tag_attributes( array( 'wp-block-list' ), $attrs ) . ">\n{$inner}</ul>" );
}

/**
 * A core Group with the given layout around already-built inner blocks.
 */
function group( string $inner, array $attrs = array() ): string {
	$attrs += array( 'layout' => array( 'type' => 'constrained' ) );
	return block( 'group', $attrs, '<div' . tag_attributes( array( 'wp-block-group' ), $attrs ) . ">\n{$inner}</div>" );
}

/**
 * A small written status label: a shrink-wrapped Group holding one Paragraph.
 *
 * @param string $label      The label, always written out.
 * @param string $background Palette slug for the label background.
 */
function status_label( string $label, string $background = 'tertiary' ): string {
	$pill = group(
		paragraph(
			text( $label ),
			array(
				'textColor' => 'heading',
				'fontSize'  => 'x-small',
				'style'     => array( 'typography' => array( 'fontWeight' => '600', 'lineHeight' => '1.4' ) ),
			)
		),
		array(
			'backgroundColor' => $background,
			'style'           => array(
				'border'  => array( 'radius' => '4px' ),
				'spacing' => array(
					'padding' => array(
						'top'    => 'var:preset|spacing|xxx-small',
						'bottom' => 'var:preset|spacing|xxx-small',
						'left'   => 'var:preset|spacing|xx-small',
						'right'  => 'var:preset|spacing|xx-small',
					),
				),
			),
			'layout'          => array( 'type' => 'flex', 'flexWrap' => 'nowrap' ),
		)
	);
	return group( $pill, array( 'layout' => array( 'type' => 'flex', 'flexWrap' => 'nowrap' ) ) );
}

/**
 * A core Buttons block with one full-width button.
 *
 * @param string $label     Button label.
 * @param string $url       Link target.
 * @param string $className Optional block style class, e.g. is-style-coral.
 */
function button( string $label, string $url, string $className = '' ): string {
	$button_attrs = array( 'width' => 100 );
	if ( $className ) {
		$button_attrs['className'] = $className;
	}
	$classes = array_filter( array( 'wp-block-button', 'has-custom-width', 'wp-block-button__width-100', $className ) );
	$button  = block(
		'button',
		$button_attrs,
		'<div class="' . esc_attr( implode( ' ', $classes ) ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">' . text( $label ) . '</a></div>'
	);
	return block( 'buttons', array(), "<div class=\"wp-block-buttons\">\n{$button}</div>" );
}

/**
 * The card treatment from house-style.md: surface fill, 1px outline, 8px radius, 24px padding.
 */
function card( string $inner, array $extra = array() ): string {
	return group(
		$inner,
		array_replace_recursive(
			array(
				'backgroundColor' => 'surface',
				'style'           => array(
					'border'     => array(
						'width'  => '1px',
						'style'  => 'solid',
						'radius' => '8px',
						'color'  => 'var:preset|color|outline',
					),
					'spacing'    => array(
						'padding'  => array(
							'top'    => 'var:preset|spacing|small',
							'bottom' => 'var:preset|spacing|small',
							'left'   => 'var:preset|spacing|small',
							'right'  => 'var:preset|spacing|small',
						),
						'blockGap' => 'var:preset|spacing|x-small',
					),
					'dimensions' => array( 'minHeight' => '100%' ),
				),
				'layout'          => array( 'type' => 'default' ),
			),
			$extra
		)
	);
}

/**
 * Message shown in the editor when a block has no records to render yet.
 */
function empty_notice( string $message, bool $is_preview ): string {
	return $is_preview ? paragraph( text( $message ), array( 'textColor' => 'neutral', 'fontSize' => 'small' ) ) : '';
}
