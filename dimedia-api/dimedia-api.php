<?php
/*
Plugin Name: DIMEDIA API
Description: Dohvaća podatke s DIMEDIA API-ja i prikazuje ih putem shortcode-ova.
Version: 1.0
Author: Tvoje Ime
*/

defined('ABSPATH') or die('No script kiddies please!');

require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/fetch.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';