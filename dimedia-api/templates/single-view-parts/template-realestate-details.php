<?php
global $realestate_data;

if (!$realestate_data) {
    echo '<p>' . __('No real estate data to display.', 'rehomes') . '</p>';
    return;
}

$currency_symbol = !empty(get_option('osf_portfolio_archive')['currency_symbol']) ? get_option('osf_portfolio_archive')['currency_symbol'] : '€';
$main_image     = $realestate_data['slika'] ?? '';
?>

<section class="single-property-content py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-4">
                <?php if (!empty($main_image)): ?>
                    <img src="<?php echo esc_url($main_image); ?>" class="img-fluid rounded shadow" style="width: 100%; height: 100%; object-fit: cover;" alt="">
                <?php endif; ?>
            </div>

            <div class="col-md-5">
                <div class="property-description" style="font-size: 1rem; line-height: 1.4;">
                    <?php
                    $opis = $realestate_data['opis'] ?? '';

                    $opis = preg_replace('/<p>(\s|&nbsp;| )*<\/p>/i', '', $opis);
                    $opis = preg_replace('/(\r?\n){2,}/', "\n", $opis);

                    echo $opis;
                    ?>
                </div>
            </div>

            <div class="col-md-3">
                <h4 class="mb-4"><?php _e('Detalji', 'rehomes'); ?></h4>
                <ul class="list-unstyled" style="font-size: 1rem;">
                    <li><strong><?php _e('Status', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['status'] ?? ''); ?></li>
                    <li><strong><?php _e('Površina', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['kvadratura'] ?? ''); ?> m²</li>
                    <li><strong><?php _e('Lokacija', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['mjesto'] ?? ''); ?></li>
                    <li><strong><?php _e('Vrsta', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['tip_nekretnine'] ?? ''); ?></li>
                    <li><strong><?php _e('Stanje', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['stanje'] ?? ''); ?></li>
                    <li><strong><?php _e('Kat', 'rehomes'); ?>:</strong> <?php echo esc_html($realestate_data['kat'] ?? ''); ?></li>
                    <li><strong><?php _e('Cijena', 'rehomes'); ?>:</strong> <?php echo esc_html($currency_symbol . ' ' . ($realestate_data['cijena'] ?? '')); ?></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($realestate_data['repeat_group'])): ?>
    <section class="property-equipment py-5 bg-light">
        <div class="container text-center">
            <h4 class="mb-4"><?php _e('Opremljenost nekretnine', 'rehomes'); ?></h4>
            <div class="row justify-content-center">
                <?php foreach ($realestate_data['repeat_group'] as $entry):
                    $title = $entry['title'] ?? '';
                    if ($title): ?>
                        <div class="col-6 col-sm-4 col-md-3 mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <span class="material-icons text-primary" style="font-size: 36px;">check_circle</span>
                                <span class="mt-2" style="font-size: 0.95rem;"><?php echo esc_html($title); ?></span>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
