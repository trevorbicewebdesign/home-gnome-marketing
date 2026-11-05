<?php
/**
 * Title: Footer
 * Slug: home-gnome/footer
 * Categories: home-gnome-site
 * Description: Name, footer navigation and the newsletter form on the dark heading colour.
 * Block Types: core/template-part/footer
 *
 * @package home-gnome
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"heading","textColor":"background","style":{"spacing":{"padding":{"top":"clamp(var(--wp--preset--spacing--medium), 6vw, var(--wp--preset--spacing--x-large))","bottom":"clamp(var(--wp--preset--spacing--medium), 6vw, var(--wp--preset--spacing--x-large))","left":"var(--wp--style--root--padding-left)","right":"var(--wp--style--root--padding-right)"}},"elements":{"link":{"color":{"text":"var:preset|color|background"},":hover":{"color":{"text":"var:preset|color|tertiary"}}}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-color has-text-color has-heading-background-color has-background has-link-color" style="padding-top:clamp(var(--wp--preset--spacing--medium), 6vw, var(--wp--preset--spacing--x-large));padding-right:var(--wp--style--root--padding-right);padding-bottom:clamp(var(--wp--preset--spacing--medium), 6vw, var(--wp--preset--spacing--x-large));padding-left:var(--wp--style--root--padding-left)">
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|medium","left":"var:preset|spacing|large"}}}} -->
<div class="wp-block-columns alignwide">
<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%">
<!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","width":"36px","height":"36px","style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"border":{"radius":"0px"}}} -->
<figure class="wp-block-image size-full is-resized has-custom-border" style="margin-top:0;margin-bottom:0"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/logo-mark-reversed.svg' ) ); ?>" alt="" style="border-radius:0px;width:36px;height:36px"/></figure>
<!-- /wp:image -->
<!-- wp:site-title {"level":0,"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"textColor":"outline","fontSize":"small"} -->
<p class="has-outline-color has-text-color has-small-font-size">Know what you have. Find where it is.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"textColor":"outline","fontSize":"x-small"} -->
<p class="has-outline-color has-text-color has-x-small-font-size">Home Gnome is proprietary software: free to self-host, not open source.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%">
<!-- wp:heading {"textColor":"background","fontSize":"small"} -->
<h2 class="wp-block-heading has-background-color has-text-color has-small-font-size">Explore</h2>
<!-- /wp:heading -->
<!-- wp:navigation {"textColor":"background","overlayMenu":"never","layout":{"type":"flex","orientation":"horizontal","flexWrap":"wrap","justifyContent":"left"},"style":{"spacing":{"blockGap":"var:preset|spacing|xx-small var:preset|spacing|small"}},"fontSize":"small"} -->
<!-- wp:navigation-link {"label":"Product","url":"/product/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Web app","url":"/web-app/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Home Assistant","url":"/home-assistant/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Integrations","url":"/integrations/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Plans &amp; hosting","url":"/plans/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Get started","url":"/get-started/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Docs","url":"/documentation/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Release notes","url":"/release-notes/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"FAQ","url":"/faq/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Contact","url":"/contact/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"About","url":"/about/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Privacy","url":"/privacy/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Terms","url":"/terms/","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%">
<!-- wp:heading {"textColor":"background","fontSize":"small"} -->
<h2 class="wp-block-heading has-background-color has-text-color has-small-font-size">Product updates</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"outline","fontSize":"small"} -->
<p class="has-outline-color has-text-color has-small-font-size">News about releases, Hosted and the native app. Unsubscribe any time.</p>
<!-- /wp:paragraph -->
<!-- wp:gravityforms/form {"formId":"5","title":false,"description":false,"ajax":true,"theme":"orbital","inputBorderRadius":"6","inputBorderColor":"#61706B","inputBackgroundColor":"#FFFFFF","inputColor":"#203835","inputPrimaryColor":"#086B67","labelFontSize":"16","labelColor":"#FFFCF7","descriptionColor":"#CBD7D1","buttonPrimaryBackgroundColor":"#086B67","buttonPrimaryColor":"#FFFCF7"} /-->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
