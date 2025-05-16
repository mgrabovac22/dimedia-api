<?php
global $realestate_data;

if (!$realestate_data) {
    echo '<p>' . __('No real estate data to display.', 'rehomes') . '</p>';
    return;
}

add_filter('rehomes_page_title_bar_custom', '__return_true');
add_filter('rehomes_page_title_bar_args', function ($args) use ($realestate_data) {
    return [
        'title'      => $realestate_data['propertyTitle'] ?? get_the_title(),
        'background' => $realestate_data['slika'] ?? '',
        'alignment'  => 'center',
    ];
});
?>

