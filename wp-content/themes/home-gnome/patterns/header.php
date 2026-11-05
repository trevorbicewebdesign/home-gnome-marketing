<?php
/**
 * Title: Header
 * Slug: home-gnome/header
 * Categories: home-gnome-site
 * Description: Logo and name, the main navigation and the primary action.
 * Block Types: core/template-part/header
 *
 * @package home-gnome
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"background","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-small","bottom":"var:preset|spacing|x-small","left":"var(--wp--style--root--padding-left)","right":"var(--wp--style--root--padding-right)"}},"border":{"bottom":{"color":"var:preset|color|outline","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--x-small);padding-right:var(--wp--style--root--padding-right);padding-bottom:var(--wp--preset--spacing--x-small);padding-left:var(--wp--style--root--padding-left);border-bottom-color:var(--wp--preset--color--outline);border-bottom-width:1px">
<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide">
<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","width":"36px","height":"36px","style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"border":{"radius":"0px"}}} -->
<figure class="wp-block-image size-full is-resized has-custom-border" style="margin-top:0;margin-bottom:0"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/logo-mark.svg' ) ); ?>" alt="" style="border-radius:0px;width:36px;height:36px"/></figure>
<!-- /wp:image -->
<!-- wp:site-title {"level":0,"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
</div>
<!-- /wp:group -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|small"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group">
<!-- wp:navigation {"textColor":"heading","overlayBackgroundColor":"background","overlayTextColor":"heading","overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"right"},"style":{"spacing":{"blockGap":"var:preset|spacing|small"}}} -->
<!-- wp:navigation-link {"label":"Product","url":"/product/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Home Assistant","url":"/home-assistant/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Plans","url":"/plans/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Docs","url":"/documentation/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Get early access","url":"/get-started/#early-access","kind":"custom","isTopLevelLink":true,"SWTHideDesktop":true,"SWTHideTab":true} /-->
<!-- /wp:navigation -->
<!-- wp:buttons {"SWTHideMob":true} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/get-started/#early-access">Get early access</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
