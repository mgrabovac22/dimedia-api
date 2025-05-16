<?php
global $realestate_data;

$equipment_items = [];

if (!empty($realestate_data['propertyUtility'])) {
    $equipment_items = array_merge($equipment_items, array_map('trim', explode(',', $realestate_data['propertyUtility'])));
}
if (!empty($realestate_data['propertyEquipment'])) {
    $equipment_items[] = trim($realestate_data['propertyEquipment']);
}
if (!empty($realestate_data['propertyPropertySpace'])) {
    $equipment_items = array_merge($equipment_items, array_map('trim', explode(',', $realestate_data['propertyPropertySpace'])));
}
if (!empty($realestate_data['distanceSea'])) {
    $equipment_items[] = 'Udaljenost od mora: ' . intval($realestate_data['distanceSea']) . ' m';
}

if (!empty($realestate_data['propertyDescriptions'])) {
    $equipment_items = array_merge($equipment_items, array_map('trim', explode(',', $realestate_data['propertyDescriptions'])));
}

if (empty($equipment_items)) return;
?>

<div class="row justify-content-center">
    <?php foreach ($equipment_items as $i => $item): ?>
        <div class="col-6 col-sm-4 col-md-3 mb-4">
            <div class="elementor-element elementor-widget-icon-box animated-fast opal-move-up" data-id="icon-<?php echo $i; ?>" data-element_type="widget" data-settings='{"_animation":"opal-move-up","_animation_delay":<?php echo ($i % 4) * 150; ?>}'>
                <div class="elementor-widget-container">
                    <div class="elementor-icon-box-wrapper">
                        <div class="elementor-icon-box-icon">
                            <span class="elementor-icon elementor-animation-">
                                <i class="opal-icon- opal-icon-check-circle opal-custom" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="elementor-icon-box-content text-center">
                            <p class="elementor-icon-box-description mb-0"><?php echo esc_html($item); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
