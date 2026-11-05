<?php
/**
 * Seeds the Home Gnome marketing site: the shared records the ACF blocks render (plans, FAQs,
 * features, integrations), the Gravity Forms from docs/forms/, the pages, the front page and the
 * basic settings. Safe to run again: everything is matched by slug or title and updated in place.
 *
 *   source ../.envrc && wp eval-file bin/seed-site.php
 *
 * The templates place the forms by ID (1 Hosted waitlist, 2 Native app notifications, 3 Product
 * updates, 4 Contact, 5 Newsletter), which is the order they import in on an empty Gravity Forms
 * install; the script warns if a form ends up with a different ID.
 *
 * @package home-gnome
 */

if ( ! defined( 'WP_CLI' ) ) {
	exit;
}

if ( ! function_exists( 'update_field' ) || ! class_exists( 'GFAPI' ) ) {
	WP_CLI::error( 'ACF Pro and Gravity Forms must be active.' );
}

/**
 * Creates or updates one post by slug and writes its ACF fields.
 */
$upsert = static function ( string $type, string $slug, string $title, array $fields = array(), array $post = array() ): int {
	$existing = get_page_by_path( $slug, OBJECT, $type );
	$data     = array_merge(
		array(
			'post_type'   => $type,
			'post_name'   => $slug,
			'post_title'  => $title,
			'post_status' => 'publish',
		),
		$post
	);
	if ( $existing ) {
		$data['ID'] = $existing->ID;
	}
	$id = wp_insert_post( wp_slash( $data ), true );
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( "$type $slug: " . $id->get_error_message() );
	}
	foreach ( $fields as $name => $value ) {
		update_field( $name, $value, $id );
	}
	return (int) $id;
};
$rows = static fn ( string $key, array $items ): array => array_map( static fn ( $v ) => array( $key => $v ), $items );

// ── Features ───────────────────────────────────────────────────────────────
$features = array(
	'things-and-places'   => array( 'Things & places', 'things_places', 'A catalog of what you keep, and the rooms, shelves and boxes that hold it.', array( 'The catalog says what something is; entries record what is actually here', 'Places sit inside places: Garage › Shelf 2 › Tool tote', 'Where a thing is now, and where it usually lives' ), '/product/#things-and-places' ),
	'counts'              => array( 'Counts & individual things', 'counts', 'Track stock by count, or one belonging with its own details.', array( 'An opened case shows 9 of 12 cans left', 'One opened jar and one sealed jar stay separate entries', 'A drill keeps its nickname, serial and owner' ), '/product/#counts' ),
	'purchases-ownership' => array( 'Purchases & ownership', 'purchases', 'Where something was bought, what it cost, and who it belongs to.', array( 'Store, price and receipt with the thing', 'Owners for shared and personal things', 'Gifts keep who they belong to' ), '/product/#purchases' ),
	'household-todos'     => array( 'Household to-dos', 'todos', 'The household\'s jobs, next to the things and places they\'re about.', array( 'A short Today list', 'Finished tasks show who did them', 'The Today list in Home Assistant, too' ), '/product/#todos' ),
	'stickers-nfc'        => array( 'Stickers & NFC codes', 'labels', 'Every place and entry has a short code for a QR sticker or an NFC tag.', array( 'Scan with the phone\'s camera to open the place', 'Tap an NFC tag to open the thing or place', 'A native scanning app is planned' ), '/product/#labels' ),
	'admin-web-app'       => array( 'Admin & web app', 'interfaces', 'Set the house up in the admin; use the web app day to day from a phone.', array( 'Both included with every hosting option', 'The web app is the phone view of the house', 'Also in Home Assistant\'s sidebar' ), '/web-app/' ),
);
$order = 10;
foreach ( $features as $slug => [ $title, $area, $summary, $benefits, $link ] ) {
	$upsert(
		'hg_feature',
		$slug,
		$title,
		array(
			'short_title'        => $title,
			'summary'            => $summary,
			'feature_area'       => $area,
			'availability'       => 'available',
			'benefits'           => $rows( 'benefit', $benefits ),
			'documentation_link' => array( 'title' => 'Read more', 'url' => $link, 'target' => '' ),
			'display_order'      => $order,
		)
	);
	$order += 10;
}
$feature_ids = get_posts( array( 'post_type' => 'hg_feature', 'posts_per_page' => -1, 'fields' => 'ids', 'orderby' => 'menu_order title' ) );
WP_CLI::log( count( $features ) . ' features' );

// ── Integrations ───────────────────────────────────────────────────────────
$upsert(
	'hg_integration',
	'home-assistant',
	'Home Assistant',
	array(
		'summary'                => 'Stock sensors, actions, NFC blueprints and the household\'s to-do lists in Home Assistant.',
		'availability'           => 'available',
		'works_with'             => array( 'self_hosted', 'hosted' ),
		'capabilities'           => $rows( 'capability', array( 'A stock sensor for each item you choose', 'Actions for automations: use one, move, stock in', 'Blueprints for NFC tags', 'The Today list as a Home Assistant to-do list', 'The web app in the sidebar' ) ),
		'requirements'           => $rows( 'requirement', array( 'Home Assistant 2025.3 or later', 'A Home Gnome server Home Assistant can reach, and an API token' ) ),
		'setup_url'              => '/get-started/#home-assistant',
		'external_service_notes' => '',
		'display_order'          => 10,
	)
);
$upsert(
	'hg_integration',
	'alexa',
	'Alexa',
	array(
		'summary'                => 'Ask where something is or how many are left, or say you used one.',
		'availability'           => 'available',
		'works_with'             => array( 'self_hosted', 'hosted' ),
		'capabilities'           => $rows( 'capability', array( '"Where is…"', '"How many… are left"', '"I used one"' ) ),
		'requirements'           => $rows( 'requirement', array( 'The Home Gnome Alexa skill', 'A public address the skill can reach, such as Home Assistant Cloud\'s' ) ),
		'setup_url'              => '',
		'external_service_notes' => 'Alexa requests go through Amazon.',
		'display_order'          => 20,
	)
);
WP_CLI::log( '2 integrations' );

// ── Plans (docs/design/plans-and-model.md, "ACF plan records (revised)") ────
$upsert(
	'hg_plan',
	'self-hosted',
	'Self-hosted',
	array(
		'record_type'            => 'hosting',
		'edition'                => 'self_hosted',
		'hosting'                => 'own_server',
		'status'                 => 'available',
		'summary'                => 'On your server or NAS.',
		'price_status'           => 'free_forever',
		'billing_model'          => 'free',
		'billing_intervals'      => array(),
		'price_note'             => 'No licence key.',
		'highlights'             => $rows( 'highlight', array( 'Server, admin and web app', 'Home Assistant and Alexa', 'One Docker image' ) ),
		'shared_feature_set'     => $feature_ids,
		'operational_inclusions' => array(),
		'operation'              => 'You manage backups and updates.',
		'address_example'        => '',
		'household_terms_status' => 'not_final',
		'includes_app'           => 'separate_purchase',
		'app_inclusion_note'     => 'Native app: a separate purchase when available.',
		'cta_label'              => 'Get early access',
		'cta_url'                => '/get-started/#early-access',
		'display_order'          => 10,
	)
);
$upsert(
	'hg_plan',
	'hosted',
	'Hosted',
	array(
		'record_type'            => 'hosting',
		'edition'                => 'hosted',
		'hosting'                => 'managed_private_instance',
		'status'                 => 'coming',
		'summary'                => 'A private instance for your household.',
		'price_status'           => 'unannounced',
		'billing_model'          => 'subscription',
		'billing_intervals'      => array( 'monthly', 'yearly' ),
		'price_note'             => 'Monthly or yearly subscription.',
		'highlights'             => $rows( 'highlight', array( 'The same complete product', 'Your own private instance' ) ),
		'shared_feature_set'     => $feature_ids,
		'operational_inclusions' => $rows( 'inclusion', array( 'Managed backups', 'Updates', 'Support' ) ),
		'operation'              => 'We run the server for you.',
		'address_example'        => 'yourhouse.homegnome',
		'household_terms_status' => 'not_final',
		'includes_app'           => 'proposed_included',
		'app_inclusion_note'     => 'The native app for the whole household.',
		'cta_label'              => 'Join the hosted waitlist',
		'cta_url'                => '/plans/#hosted-waitlist',
		'gravity_form_id'        => 1,
		'display_order'          => 20,
	)
);
$upsert(
	'hg_plan',
	'native-app',
	'Native app',
	array(
		'record_type'            => 'companion_app',
		'edition'                => 'native_app',
		'hosting'                => 'not_applicable',
		'status'                 => 'planned',
		'summary'                => 'On your iOS or Android device.',
		'price_status'           => 'unannounced',
		'billing_model'          => 'one_time',
		'billing_intervals'      => array(),
		'price_note'             => 'One-time purchase for self-hosters.',
		'highlights'             => $rows( 'highlight', array( 'Barcode and NFC scanning', 'Connects to either hosting option' ) ),
		'shared_feature_set'     => array(),
		'operational_inclusions' => array(),
		'operation'              => 'Planned app-store distribution.',
		'address_example'        => '',
		'household_terms_status' => 'not_final',
		'includes_app'           => 'not_applicable',
		'app_inclusion_note'     => 'Inclusion with Hosted proposed.',
		'compatible_editions'    => array( 'self_hosted', 'hosted' ),
		'platforms'              => array( 'ios', 'android' ),
		'cta_label'              => 'Get notified',
		'cta_url'                => '/plans/#native-app',
		'gravity_form_id'        => 2,
		'display_order'          => 30,
	)
);
WP_CLI::log( '3 plans' );

// ── FAQs (plans-and-model.md, waitlist-stage answers) ───────────────────────
$faqs = array(
	'open-source'          => array( 'Is Home Gnome open source?', 'No. The code is proprietary. The complete self-hosted product is free to use, forever, without a licence key.', 'general', array( 'home', 'plans', 'faq' ) ),
	'native-app-required'  => array( 'Is the native app required?', 'No. The browser web app is included with both hosting options; the app adds barcode and NFC scanning.', 'native_app', array( 'home', 'plans', 'faq' ) ),
	'hosted-data'          => array( 'What happens to my data on Hosted?', 'Your household\'s records live in its private instance, with backups managed by us. Hosting location, access, retention and deletion details are not yet announced.', 'data', array( 'home', 'plans', 'faq' ) ),
	'hosted-to-self'       => array( 'Can I move from Hosted to self-hosted?', 'Both run the same product. A supported export and migration process is not yet announced.', 'hosting', array( 'plans', 'faq' ) ),
	'native-app-cost'      => array( 'What will the native app cost?', 'A one-time app-store purchase for self-hosters. Pricing unannounced; inclusion with Hosted proposed.', 'native_app', array( 'home', 'plans', 'faq' ) ),
	'household-members'    => array( 'What about other people in my household?', 'Hosted is one private instance per household. Native app access for everyone in it is proposed; purchase and sharing details are not final.', 'hosting', array( 'plans', 'faq' ) ),
	'cancel-hosted'        => array( 'What happens if I cancel Hosted?', 'Cancellation, export and retention terms are not yet announced.', 'hosting', array( 'plans', 'faq' ) ),
);
$order = 10;
foreach ( $faqs as $slug => [ $question, $answer, $topic, $show_on ] ) {
	$upsert( 'hg_faq', $slug, $question, array( 'answer' => $answer, 'topic' => $topic, 'show_on' => $show_on, 'display_order' => $order ) );
	$order += 10;
}
WP_CLI::log( count( $faqs ) . ' FAQs' );

// ── Gravity Forms ───────────────────────────────────────────────────────────
require_once GFCommon::get_base_path() . '/export.php';
$form_files = array( 'hosted-waitlist' => 1, 'native-app' => 2, 'product-updates' => 3, 'contact' => 4, 'newsletter' => 5 );
foreach ( $form_files as $file => $expected_id ) {
	$json  = file_get_contents( dirname( __DIR__ ) . "/docs/forms/$file.json" );
	$title = json_decode( $json, true )['0']['title'];
	$found = array_values( array_filter( GFAPI::get_forms( null ), static fn ( $f ) => $f['title'] === $title ) );
	if ( $found ) {
		$id = (int) $found[0]['id'];
	} else {
		GFExport::import_json( $json, $imported );
		$id = (int) ( $imported[0]['id'] ?? 0 );
		WP_CLI::log( "imported form $title" );
	}
	if ( $id !== $expected_id ) {
		WP_CLI::warning( "Form \"$title\" has ID $id; the templates place it as $expected_id. Update the Gravity Forms blocks or re-import on an empty install." );
	}
}

// ── Pages ───────────────────────────────────────────────────────────────────
// Every page's content is a list of theme patterns (patterns/*.php), so the sections are versioned
// with the theme and editable in the page editor. Patterns sit at the top level of the content
// because Spectra generates a Container's CSS only for blocks it finds there (it does not follow a
// pattern nested inside another block). Home uses templates/front-page.html and every other page
// templates/page.html; each body pattern opens with the page's own title.
$sections = static fn ( string ...$slugs ): string => implode(
	"\n",
	array_map( static fn ( $slug ) => '<!-- wp:pattern {"slug":"home-gnome/' . $slug . '"} /-->', $slugs )
);
$pages    = array(
	'home'           => array( 'Home', $sections( 'hero', 'hero-facts', 'things-places', 'counts', 'purchases', 'todos', 'hosting-connections', 'run-it-yourself', 'faq', 'closing-cta' ), '' ),
	'product'        => array( 'Product', $sections( 'page-product', 'closing-cta' ), '' ),
	'web-app'        => array( 'Web app', $sections( 'page-web-app', 'closing-cta' ), '' ),
	'home-assistant' => array( 'Home Assistant', $sections( 'page-home-assistant', 'closing-cta' ), '' ),
	'integrations'   => array( 'Integrations', $sections( 'page-integrations', 'closing-cta' ), '' ),
	'plans'          => array( 'Plans & hosting', $sections( 'plans-intro', 'plans-comparison', 'plans-terms', 'plans-faq', 'plans-waitlist', 'plans-native-app', 'closing-cta' ), '' ),
	'get-started'    => array( 'Get started', $sections( 'page-get-started' ), '' ),
	'documentation'  => array( 'Docs', $sections( 'docs-intro', 'docs-guides', 'docs-interfaces', 'docs-help', 'closing-cta' ), '' ),
	'release-notes'  => array( 'Release notes', $sections( 'page-release-notes', 'closing-cta' ), '' ),
	'faq'            => array( 'FAQ', $sections( 'page-faq', 'closing-cta' ), '' ),
	'contact'        => array( 'Contact', $sections( 'page-contact' ), '' ),
	'about'          => array( 'About', $sections( 'page-about', 'closing-cta' ), '' ),
	'privacy'        => array( 'Privacy', $sections( 'page-privacy' ), '' ),
	'terms'          => array( 'Terms', $sections( 'page-terms' ), '' ),
);
$ids      = array();
$order    = 0;
foreach ( $pages as $slug => [ $title, $content, $template ] ) {
	$ids[ $slug ] = $upsert( 'page', $slug, $title, array(), array( 'post_content' => $content, 'menu_order' => $order++, 'page_template' => $template ?: 'default' ) );
	// Spectra caches each page's generated CSS; let it rebuild from the new content on first view.
	delete_post_meta( $ids[ $slug ], '_uag_page_assets' );
}
WP_CLI::log( count( $pages ) . ' pages' );

// WordPress's sample content is not part of this site.
foreach ( array( array( 'hello-world', 'post' ), array( 'sample-page', 'page' ), array( 'privacy-policy', 'page' ) ) as [ $slug, $type ] ) {
	$sample = get_page_by_path( $slug, OBJECT, $type );
	if ( $sample && 'privacy' !== $slug ) {
		wp_trash_post( $sample->ID );
	}
}

// ── Settings ────────────────────────────────────────────────────────────────
update_option( 'blogname', 'Home Gnome' );
update_option( 'blogdescription', 'Know what you have. Find where it is.' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $ids['home'] );
update_option( 'wp_page_for_privacy_policy', $ids['privacy'] );
update_option( 'permalink_structure', '/%postname%/' );
flush_rewrite_rules();
WP_CLI::success( 'Seeded. Front page: Home; forms 1-5; records for plans, FAQs, features and integrations.' );
