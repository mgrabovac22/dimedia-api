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

function dimedia_property_shortcode() {
    if (!isset($_GET['id'])) {
        return '<p>Nema odabrane nekretnine.</p>';
    }

    $feeds_raw = get_option('dimedia_feeds', '');
    $feeds = array_filter(array_map('trim', explode("\n", $feeds_raw)));
    $feed_index = 0;

    error_log("Dimedia feedovi: " . print_r($feeds, true));

    if (!isset($feeds[$feed_index])) {
        return '<p>Neispravan feed.</p>';
    }

    $property_id = sanitize_text_field($_GET['id']);
    $property = dimedia_fetch_single_property_from_feed($feeds[$feed_index], $property_id);

    if (!$property) {
        return '<p>Nekretnina nije pronađena.</p>';
    }

    ob_start();
    global $realestate_data;
    $realestate_data = $property;
    include plugin_dir_path(__FILE__) . '../templates/template-realestate-single.php';
    return ob_get_clean();
}
add_shortcode('dimedia_property', 'dimedia_property_shortcode');

function show_property_location_shortcode($atts) {
    global $realestate_data;

    if (empty($realestate_data['mapLatitude']) || empty($realestate_data['mapLongitude'])) {
        return '<p>' . __('Lokacija nije dostupna.', 'rehomes') . '</p>';
    }

    $lat = esc_attr($realestate_data['mapLatitude']);
    $lng = esc_attr($realestate_data['mapLongitude']);
    $address = esc_html($realestate_data['propertyAddress'] ?? '');
    
    if (!$address) {
        $address = "$lat, $lng";
    }

    $map_src = "https://maps.google.com/maps?q={$lat},{$lng}&t=m&z=17&output=embed";

    ob_start();
    ?>
    <section class="elementor-section elementor-top-section elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" style="max-width: 1200px; margin: 0 auto;">
        <div class="elementor-container elementor-column-gap-no" style="display: flex; flex-wrap: wrap;">
            <div class="elementor-column elementor-col-50" style="flex: 0 0 50%; max-width: 50%; padding: 10px;">
                <div class="elementor-widget-google_maps">
                    <iframe loading="lazy" src="<?php echo $map_src; ?>" title="<?php echo $address; ?>" aria-label="<?php echo $address; ?>" style="border:0; width:100%; height:350px;" allowfullscreen></iframe>
                </div>
            </div>
            <div class="elementor-column elementor-col-50" style="flex: 0 0 50%; max-width: 50%; padding: 10px; display: flex; flex-direction: column; justify-content: center;">
                <h2 class="elementor-heading-title elementor-size-default"><?php _e('Adresa', 'rehomes'); ?></h2>
                <div class="elementor-text-editor elementor-clearfix">
                    <p><?php echo $address; ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('property_location_map', 'show_property_location_shortcode');




