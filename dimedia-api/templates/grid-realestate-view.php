<?php

function dimedia_render_property($property, $index = 0) {
    $categories = $property['categories'] ?? ['izdvojeno'];
    $category_classes = implode(' ', array_map('sanitize_html_class', $categories));
    $post_id = intval($property['id'] ?? $index + 1);

    ob_start(); ?>
    <div class="column-item portfolio-entries __all <?= esc_attr($category_classes) ?>">
        <article id="post-<?= $post_id ?>" class="portfolio post-<?= $post_id ?> osf_portfolio type-osf_portfolio status-publish has-post-thumbnail hentry <?= esc_attr($category_classes) ?>">
            <div class="portfolio-inner">
                <div class="portfolio-post-thumbnail" style="position:relative; overflow:hidden;">
                    <img decoding="async" width="810" height="700"
                         src="<?= esc_url($property['images'][0] ?? '') ?>"
                         class="attachment-rehomes-featured-image-full size-rehomes-featured-image-full wp-post-image"
                         alt="<?= esc_attr($property['type'] ?? '') ?>">
                    <a class="thumbnail-overlay" href="<?= esc_url($property['url'] ?? '#') ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;"></a>
                </div>
                <div class="portfolio-content">
                    <div class="line"></div>
                    <div class="portfolio-number"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="portfolio-content-inner">
                        <h2 class="entry-title">
                            <a href="<?= esc_url(site_url('/nekretnina') . '?id=' . urlencode($property['id'])) ?>">
                                <?= esc_html(($property['type'] ?? 'Nepoznat tip') . ' - ' . ($property['title'] ?? ($property['location'] ?? 'Bez naslova'))) ?>
                            </a>
                        </h2>
                        <div class="entry-locations">
                            <?= esc_html($property['location'] ?? '') ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    <?php
    return ob_get_clean();
}

function dimedia_render_list($properties) {
    ob_start();
    ?>
    <div class="elementor-post-wrapper elementor-portfolio-style-caption" id="isotope-container">
        <div class="row isotope-grid" data-elementor-columns="3" style="position: relative;">
            <?php foreach ($properties as $index => $property): ?>
                <?= dimedia_render_property($property, $index) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
