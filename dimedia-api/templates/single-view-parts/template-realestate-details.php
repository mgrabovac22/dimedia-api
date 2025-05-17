<?php
global $realestate_data;

if (!$realestate_data) {
    echo '<p>' . __('No real estate data to display.', 'rehomes') . '</p>';
    return;
}

$currency_symbol = !empty(get_option('osf_portfolio_archive')['currency_symbol']) ? get_option('osf_portfolio_archive')['currency_symbol'] : '€';
$main_image = $realestate_data['slika'] ?? '';
$opis = $realestate_data['opis'] ?? '';
$wide_area = $realestate_data['wider_area'] ?? '';
?>

<div class="overview-style-" id="overview">
    <div class="single-portfolio-summary-meta row w-100">
        <div class="col-xl-9 col-12">
            <div class="row">
                <?php if (!empty($main_image)): ?>
                    <div class="col-xl-6 col-12 pt-3">
                        <img src="<?php echo esc_url($main_image); ?>"
                             class="attachment-rehomes-gallery-image size-rehomes-gallery-image wp-post-image img-fluid"
                             alt="">
                    </div>
                <?php endif; ?>
                <div class="col-xl-6 col-12">
                    <div class="px-xl-3 property-description" style="font-size: 1rem; line-height: 1.5;">
                        <?php
                        $opis = preg_replace('/<p>(\s|&nbsp;| )*<\/p>/i', '', $opis);
                        $opis = preg_replace('/(\r?\n){2,}/', "\n", $opis);
                        echo $opis;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-12">
            <ul class="single-portfolio-summary-meta-list">
                <li><span class="meta-title"><?php _e('Status', 'rehomes'); ?> </span><span class="meta-value"><?php echo esc_html($realestate_data['status'] ?? ''); ?></span></li>
                <li><span class="meta-title"><?php _e('Površina', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['kvadratura'] ?? ''); ?> m²</span></li>
                <li><span class="meta-title"><?php _e('Lokacija', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['mjesto'] ?? ''); ?></span></li>
                <li><span class="meta-title"><?php _e('Vrsta', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['tip_nekretnine'] ?? ''); ?></span></li>
                <?php if (!empty($realestate_data['wider_area'])): ?>
                    <li><span class="meta-title"><?php _e('Šira lokacija', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['wider_area']); ?></span></li>
                <?php endif; ?>
                <?php if (!empty($realestate_data['broj_soba'])): ?>
                    <li><span class="meta-title"><?php _e('Broj soba', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['numberOfBedrooms']); ?></span></li>
                <?php endif; ?>
                <li><span class="meta-title"><?php _e('Kat', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html($realestate_data['numberOfFloors'] ?? ''); ?></span></li>
                <li><span class="meta-title"><?php _e('Cijena (€)', 'rehomes'); ?></span><span class="meta-value"><?php echo esc_html(number_format(floatval($realestate_data['cijena']), 2, ',', '.')); ?></span></li>
                <?php if (!empty($realestate_data['kvadratura']) && is_numeric($realestate_data['kvadratura']) && !empty($realestate_data['cijena']) && is_numeric($realestate_data['cijena'])): ?>
                    <li><span class="meta-title"><?php _e('Cijena (€/m²)', 'rehomes'); ?></span>
                        <span class="meta-value">
                            <?php
                            $cijena_m2 = floatval($realestate_data['cijena']) / floatval($realestate_data['kvadratura']);
                            echo esc_html(number_format($cijena_m2, 2, ',', '.'));
                            ?>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
