<?php
global $realestate_data;

$gallery_images = $realestate_data['slike'] ?? [];

if (empty($gallery_images)) {
    return;
}
?>

<section class="property-gallery py-5">
    <div class="container">
        <h4 class="text-center mb-5"><?php _e('Fotogalerija', 'rehomes'); ?></h4>
        <div class="masonry-grid row g-3">
            <?php foreach ($gallery_images as $img): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="gallery-item position-relative overflow-hidden rounded shadow-sm" style="aspect-ratio: 4/3;">
                        <img src="<?php echo esc_url($img); ?>" alt="" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
