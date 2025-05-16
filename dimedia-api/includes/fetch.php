<?php

function dimedia_fetch_data($feed_url) {
    if (empty($feed_url)) {
        error_log('DIMEDIA fetch: Feed URL nije definiran!');
        return [];
    }
    $response = wp_remote_get($feed_url, [
        'timeout' => 10,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    if (is_wp_error($response)) {
        error_log('DIMEDIA API fetch error: ' . $response->get_error_message());
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('DIMEDIA API JSON decode error: ' . json_last_error_msg());
        return [];
    }

    if (!isset($data['properties']) || !is_array($data['properties'])) {
        error_log('DIMEDIA API unexpected response structure');
        return [];
    }

    return $data['properties'];
}
