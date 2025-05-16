<?php
require_once plugin_dir_path(__FILE__) . 'fetch.php';
require_once plugin_dir_path(__FILE__) . 'grid-parser.php';
require_once plugin_dir_path(__FILE__) . '../templates/grid-realestate-view.php';

function dimedia_shortcode($atts) {
    $atts = shortcode_atts([
        'index' => 0,
        'view' => 'list',
    ], $atts);

    $feeds_raw = get_option('dimedia_feeds', '');

    error_log('DIMEDIA feeds option: ' . get_option('dimedia_feeds'));
    if (empty($feeds_raw)) {
        return '<p>Nema konfiguriranih feedova.</p>';
    }

    $feeds = array_filter(array_map('trim', explode("\n", $feeds_raw)));
    $index = intval($atts['index']);

    if (!isset($feeds[$index])) {
        return '<p>Neispravan feed indeks.</p>';
    }

    $url = $feeds[$index];
    $data = dimedia_fetch_data($url);

    error_log('DIMEDIA fetched data count: ' . count($data));
    error_log('DIMEDIA fetched data preview: ' . print_r(array_slice($data, 0, 1), true));

    if (empty($data)) {
    return '<p>Trenutno nema dostupnih nekretnina.</p>';
    }

    if ($atts['view'] === 'list') {
        return dimedia_render_grid_view($url);
    }

}
add_shortcode('dimedia', 'dimedia_shortcode');

function dimedia_load_property_data() {
    if (!isset($_GET['id'])) {
        return false;
    }

    $feeds_raw = get_option('dimedia_feeds', '');
    $feeds = array_filter(array_map('trim', explode("\n", $feeds_raw)));
    $feed_index = 0;

    if (!isset($feeds[$feed_index])) {
        return false;
    }

    $property_id = sanitize_text_field($_GET['id']);
    $property = dimedia_fetch_single_property_from_feed($feeds[$feed_index], $property_id);

    if (!$property) {
        return false;
    }

    global $realestate_data;
    $realestate_data = $property;

    include plugin_dir_path(__FILE__) . '../templates/template-realestate-single.php';

    return true;
}

function dimedia_property_details_shortcode() {
    if (!dimedia_load_property_data()) {
        return '<p>Nekretnina nije pronađena ili nije odabrana.</p>';
    }

    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/single-view-parts/template-realestate-details.php';
    return ob_get_clean();
}
add_shortcode('dimedia_property_details', 'dimedia_property_details_shortcode');

function dimedia_property_equipment_shortcode() {
    if (!dimedia_load_property_data()) {
        return '<p>Nekretnina nije pronađena ili nije odabrana.</p>';
    }

    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/single-view-parts/template-realestate-equipment.php';
    return ob_get_clean();
}
add_shortcode('dimedia_property_equipment', 'dimedia_property_equipment_shortcode');

function dimedia_property_gallery_shortcode() {
    if (!dimedia_load_property_data()) {
        return '<p>Nekretnina nije pronađena ili nije odabrana.</p>';
    }

    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/single-view-parts/template-realestate-gallery.php';
    return ob_get_clean();
}
add_shortcode('dimedia_property_gallery', 'dimedia_property_gallery_shortcode');






