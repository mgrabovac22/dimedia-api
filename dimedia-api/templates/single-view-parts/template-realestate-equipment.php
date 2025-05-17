<?php
global $realestate_data;

$equipment_items = [];

if (!empty($realestate_data['propertyUtility'])) {
    $equipment_items = array_merge(
        $equipment_items,
        array_map('trim', explode(',', $realestate_data['propertyUtility']))
    );
}

if (!empty($realestate_data['propertyEquipment'])) {
    $equipment_items = array_merge(
        $equipment_items,
        array_map('trim', explode(',', $realestate_data['propertyEquipment']))
    );
}

if (!empty($realestate_data['propertyDescriptions'])) {
    $equipment_items = array_merge(
        $equipment_items,
        array_map('trim', explode(',', $realestate_data['propertyDescriptions']))
    );
}

$distance_text = null;
if (!empty($realestate_data['distanceSea'])) {
    $distance_text = 'Udaljenost od mora: ' . intval($realestate_data['distanceSea']) . ' m';
} elseif (!empty($realestate_data['distancePublicTransportation'])) {
    $distance_text = 'Udaljenost od javnog prijevoza: ' . intval($realestate_data['distancePublicTransportation']) . ' m';
}

if (empty($equipment_items) && !$distance_text) return;
?>

<?php if ($distance_text): ?>
    <div class="elementor-widget-container text-center mb-4" id="amenities">
        <p class="fw-medium" style="font-size: 1rem;"><?php echo esc_html($distance_text); ?></p>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <?php foreach ($equipment_items as $i => $item): ?>
        <div class="col-6 col-sm-4 col-md-3 mb-4">
            <div class="elementor-element elementor-element-icon-<?php echo $i; ?> animated-fast elementor-view-default elementor-position-top icon-box-default elementor-vertical-align-top elementor-widget elementor-widget-icon-box animated opal-move-up"
                 data-id="icon-<?php echo $i; ?>"
                 data-element_type="widget"
                 data-widget_type="icon-box.default"
                 data-settings='{"_animation":"opal-move-up","_animation_delay":<?php echo ($i % 4) * 150; ?>}'>
                 
                <div class="elementor-widget-container">
                    <div class="elementor-icon-box-wrapper elementor-button-">
                        
                        <div class="elementor-icon-box-icon">
                            <span class="elementor-icon elementor-animation-" style="font-size: 60px;">
                                <i class="opal-icon- opal-icon-check-circle opal-custom" aria-hidden="true"></i>
                            </span>
                        </div>
                        
                        <div class="elementor-icon-box-content text-center">
                            <h3 class="elementor-icon-box-title" style="font-size: 1.0rem; margin-top: 0.75rem;">
                                <span></span>
                            </h3>
                            <p class="elementor-icon-box-description"><?php echo esc_html($item); ?></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
