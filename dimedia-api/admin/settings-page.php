<?php
function dimedia_add_admin_menu() {
    add_menu_page(
        'DIMEDIA API',
        'DIMEDIA API',
        'manage_options',
        'dimedia_api',
        'dimedia_settings_page',
        'dashicons-admin-site-alt3',
        20
    );
}
add_action('admin_menu', 'dimedia_add_admin_menu');


function dimedia_settings_page() {
    ?>
    <div class="wrap">
        <h1>DIMEDIA API Postavke</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('dimedia_options');
                do_settings_sections('dimedia_api');
                submit_button();
            ?>
        </form>
        <?php dimedia_show_feed_shortcodes(); ?>
    </div>
    <?php
}

function dimedia_show_feed_shortcodes() {
    $feeds = array_filter(array_map('trim', explode("\n", get_option('dimedia_feeds', ''))));
    if (empty($feeds)) return;

    echo '<h2>Dostupni shortcode-ovi</h2><ul>';
    foreach ($feeds as $i => $url) {
        echo "<li><code>[dimedia index={$i} view=list]</code> → {$url}</li>";
    }
    echo '</ul>';
}

function dimedia_register_settings() {
    register_setting('dimedia_options', 'dimedia_feeds');

    add_settings_section('dimedia_main', 'Postavke konekcija', function(){
        echo '<p>Unesite URL-ove API feedova (jedan po liniji). Primjer: <code>https://api.dimediacrm.com/v2/feed/DFCE0/website/1</code></p>';
    }, 'dimedia_api');

    add_settings_field(
        'dimedia_feeds',
        'API Feed URL-ovi',
        'dimedia_feeds_callback',
        'dimedia_api',
        'dimedia_main'
    );
}

function dimedia_feeds_callback() {
    $feeds = get_option('dimedia_feeds', "https://api.dimediacrm.com/v2/feed/DFCE0/website/1");
    echo '<textarea name="dimedia_feeds" rows="7" cols="50" class="large-text code">' . esc_textarea($feeds) . '</textarea>';
}

add_action('admin_init', 'dimedia_register_settings');
