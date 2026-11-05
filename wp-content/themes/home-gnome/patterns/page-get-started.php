<?php
/**
 * Title: Page: Get started
 * Slug: home-gnome/page-get-started
 * Categories: home-gnome-pages
 * Description: Prerequisites, the Docker Compose steps, Home Assistant, and the early-access form.
 *
 * @package home-gnome
 */
?>
<!-- wp:uagb/container {"block_id":"1958bb6a","isBlockRootParent":true,"contentWidth":"alignfull","innerContentWidth":"alignwide","innerContentCustomWidthDesktop":720,"directionDesktop":"column","alignItemsDesktop":"flex-start","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","topPaddingDesktop":64,"bottomPaddingDesktop":32,"leftPaddingDesktop":32,"rightPaddingDesktop":32,"topPaddingTablet":48,"bottomPaddingTablet":24,"leftPaddingTablet":32,"rightPaddingTablet":32,"topPaddingMobile":32,"bottomPaddingMobile":24,"leftPaddingMobile":24,"rightPaddingMobile":24,"paddingLink":false,"rowGapDesktop":48,"rowGapTablet":32,"rowGapMobile":24,"columnGapDesktop":48,"columnGapTablet":32,"columnGapMobile":24,"variationSelected":true,"backgroundType":"color","backgroundColor":"var(--wp--preset--color--background)"} -->
<div class="wp-block-uagb-container uagb-block-1958bb6a alignfull uagb-is-root-container"><div class="uagb-container-inner-blocks-wrap">
<!-- wp:uagb/container {"block_id":"22b4fe0c","widthDesktop":100,"widthTablet":100,"widthMobile":100,"directionDesktop":"column","alignItemsDesktop":"flex-start","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","rowGapDesktop":16,"columnGapDesktop":16,"variationSelected":true,"topPaddingDesktop":0,"bottomPaddingDesktop":0,"leftPaddingDesktop":0,"rightPaddingDesktop":0,"paddingLink":false} -->
<div class="wp-block-uagb-container uagb-block-22b4fe0c">
<!-- wp:post-title {"level":1,"fontSize":"xxx-large","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
</div>
<!-- /wp:uagb/container -->
</div></div>
<!-- /wp:uagb/container -->
<!-- wp:uagb/container {"block_id":"7e3916fa","isBlockRootParent":true,"contentWidth":"alignfull","innerContentWidth":"alignwide","innerContentCustomWidthDesktop":720,"directionDesktop":"column","alignItemsDesktop":"flex-start","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","topPaddingDesktop":0,"bottomPaddingDesktop":64,"leftPaddingDesktop":32,"rightPaddingDesktop":32,"topPaddingTablet":0,"bottomPaddingTablet":48,"leftPaddingTablet":32,"rightPaddingTablet":32,"topPaddingMobile":0,"bottomPaddingMobile":40,"leftPaddingMobile":24,"rightPaddingMobile":24,"paddingLink":false,"rowGapDesktop":48,"rowGapTablet":32,"rowGapMobile":24,"columnGapDesktop":48,"columnGapTablet":32,"columnGapMobile":24,"variationSelected":true,"backgroundType":"color","backgroundColor":"var(--wp--preset--color--background)"} -->
<div class="wp-block-uagb-container uagb-block-7e3916fa alignfull uagb-is-root-container"><div class="uagb-container-inner-blocks-wrap">
<!-- wp:uagb/container {"block_id":"9de1a28b","widthDesktop":100,"widthTablet":100,"widthMobile":100,"directionDesktop":"column","alignItemsDesktop":"flex-start","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","rowGapDesktop":16,"columnGapDesktop":16,"variationSelected":true,"topPaddingDesktop":0,"bottomPaddingDesktop":0,"leftPaddingDesktop":0,"rightPaddingDesktop":0,"paddingLink":false} -->
<div class="wp-block-uagb-container uagb-block-9de1a28b">
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"large"} -->
<p class="has-large-font-size" style="margin-top:0;margin-bottom:0">Home Gnome runs as one Docker image on a home server, a NAS or any machine with Docker. The free download isn't public yet: the code lives in private repositories, and early access is by invitation.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0">Before you start</h2>
<!-- /wp:heading -->
<!-- wp:list {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<ul class="wp-block-list" style="margin-top:0;margin-bottom:0">
<!-- wp:list-item -->
<li>Docker with Docker Compose 2.24 or later, running.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Access to the Home Gnome repository on GitHub (early access).</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>A place to keep backups of the <code>/data</code> volume.</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0">1. Build and start it</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin-top:0;margin-bottom:0">From a clone of the repository:</p>
<!-- /wp:paragraph -->
<!-- wp:code {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<pre class="wp-block-code" style="margin-top:0;margin-bottom:0"><code>docker compose up -d --build --wait</code></pre>
<!-- /wp:code -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"textColor":"neutral","fontSize":"small"} -->
<p class="has-neutral-color has-text-color has-small-font-size" style="margin-top:0;margin-bottom:0"><code>--wait</code> matters: each start migrates the database before the server answers.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0">2. Create your admin account</h2>
<!-- /wp:heading -->
<!-- wp:code {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<pre class="wp-block-code" style="margin-top:0;margin-bottom:0"><code>docker compose exec app php artisan gnome:admin you@example.com</code></pre>
<!-- /wp:code -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin-top:0;margin-bottom:0">Then sign in at <code>http://&lt;your server&gt;:8080/admin</code>.</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0">3. Add your first place</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin-top:0;margin-bottom:0">Start with one shelf: add the room, the shelf on it and a few things on the shelf, then print its sticker.</p>
<!-- /wp:paragraph -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Set the address you use</summary>
<!-- wp:paragraph -->
<p>Set <code>APP_URL</code> in a <code>.env.docker</code> file beside the Compose file, instead of the default <code>http://localhost:8080</code>.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary>Behind a reverse proxy</summary>
<!-- wp:paragraph -->
<p>Bind the port to <code>127.0.0.1</code> and name the proxy in <code>TRUSTED_PROXIES</code>. The server itself serves plain HTTP on 8080.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:heading {"anchor":"home-assistant","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 id="home-assistant" class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0">Add Home Assistant</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin-top:0;margin-bottom:0">Home Assistant 2025.3 or later. Install the Home Gnome integration from its release zip into <code>custom_components</code>, restart Home Assistant, then add the integration with your server's address and an API token.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"typography":{"fontWeight":"600"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="margin-top:0;margin-bottom:0;font-weight:600"><a href="/home-assistant/">What the integration does →</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:uagb/container -->
</div></div>
<!-- /wp:uagb/container -->
<!-- wp:uagb/container {"block_id":"ba30554a","isBlockRootParent":true,"contentWidth":"alignfull","innerContentWidth":"alignwide","innerContentCustomWidthDesktop":1200,"directionDesktop":"row","directionTablet":"column","directionMobile":"column","alignItemsDesktop":"flex-start","alignItemsTablet":"stretch","justifyContentDesktop":"space-between","wrapDesktop":"nowrap","topPaddingDesktop":64,"bottomPaddingDesktop":64,"leftPaddingDesktop":32,"rightPaddingDesktop":32,"topPaddingTablet":48,"bottomPaddingTablet":48,"leftPaddingTablet":32,"rightPaddingTablet":32,"topPaddingMobile":32,"bottomPaddingMobile":32,"leftPaddingMobile":24,"rightPaddingMobile":24,"paddingLink":false,"rowGapDesktop":48,"rowGapTablet":32,"rowGapMobile":24,"columnGapDesktop":48,"columnGapTablet":32,"columnGapMobile":24,"variationSelected":true,"backgroundType":"color","backgroundColor":"var(--wp--preset--color--tertiary)"} -->
<div class="wp-block-uagb-container uagb-block-ba30554a alignfull uagb-is-root-container"><div class="uagb-container-inner-blocks-wrap">
<!-- wp:uagb/container {"block_id":"1a88f25f","widthDesktop":45,"widthTablet":100,"widthMobile":100,"directionDesktop":"column","alignItemsDesktop":"flex-start","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","rowGapDesktop":16,"columnGapDesktop":16,"variationSelected":true,"topPaddingDesktop":0,"bottomPaddingDesktop":0,"leftPaddingDesktop":0,"rightPaddingDesktop":0,"paddingLink":false} -->
<div class="wp-block-uagb-container uagb-block-1a88f25f">
<!-- wp:heading {"anchor":"early-access","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<h2 id="early-access" class="wp-block-heading" style="margin-top:0;margin-bottom:0">Get early access</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
<p style="margin-top:0;margin-bottom:0">Leave your email for an invitation and news when the free download is public. The download will never depend on this list.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:uagb/container -->
<!-- wp:uagb/container {"block_id":"adcda330","widthDesktop":55,"widthTablet":100,"widthMobile":100,"directionDesktop":"column","alignItemsDesktop":"stretch","justifyContentDesktop":"flex-start","wrapDesktop":"nowrap","rowGapDesktop":16,"columnGapDesktop":16,"variationSelected":true,"backgroundType":"color","backgroundColor":"var(--wp--preset--color--surface)","topPaddingDesktop":32,"topPaddingMobile":24,"bottomPaddingDesktop":32,"bottomPaddingMobile":24,"leftPaddingDesktop":32,"leftPaddingMobile":24,"rightPaddingDesktop":32,"rightPaddingMobile":24,"paddingLink":false,"containerBorderTopLeftRadius":12,"containerBorderTopRightRadius":12,"containerBorderBottomLeftRadius":12,"containerBorderBottomRightRadius":12} -->
<div class="wp-block-uagb-container uagb-block-adcda330">
<!-- wp:gravityforms/form {"formId":"3","title":false,"description":false,"ajax":true,"theme":"orbital","inputBorderRadius":"6","inputBorderColor":"#61706B","inputBackgroundColor":"#FFFFFF","inputColor":"#203835","inputPrimaryColor":"#086B67","labelFontSize":"16","labelColor":"#203835","descriptionColor":"#61706B","buttonPrimaryBackgroundColor":"#086B67","buttonPrimaryColor":"#FFFCF7"} /-->
</div>
<!-- /wp:uagb/container -->
</div></div>
<!-- /wp:uagb/container -->
