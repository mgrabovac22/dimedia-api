<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('dimedia_feeds');
