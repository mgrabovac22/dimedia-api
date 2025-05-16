<?php
global $realestate_data;

if (empty($realestate_data)) {
    return;
}

$equipment_items = [];

if (!empty($realestate_data['propertyUtility'])) {
    $utility_items = array_map('trim', explode(',', $realestate_data['propertyUtility']));
    $equipment_items = array_merge($equipment_items, $utility_items);
}

if (!empty($realestate_data['propertyEquipment'])) {
    $equipment_items[] = trim($realestate_data['propertyEquipment']);
}

if (!empty($realestate_data['propertyPropertySpace'])) {
    $space_items = array_map('trim', explode(',', $realestate_data['propertyPropertySpace']));
    $equipment_items = array_merge($equipment_items, $space_items);
}

if (!empty($realestate_data['distanceSea'])) {
    $equipment_items[] = __('Udaljenost od mora', 'rehomes') . ': ' . intval($realestate_data['distanceSea']) . ' m';
}

error_log('Dmarin1');

if (empty($equipment_items)) {
    error_log('marin2');
    return;
}
?>

<section class="property-equipment py-5 bg-light">
    <div class="container text-center">
        <h4 class="mb-4"><?php _e('Opremljenost nekretnine', 'rehomes'); ?></h4>
        <div class="row justify-content-center">
            <?php foreach ($equipment_items as $item): ?>
                <div class="col-6 col-sm-4 col-md-3 mb-4">
                    <div class="d-flex flex-column align-items-center">
                        <span class="material-icons text-primary" style="font-size: 36px;">check_circle</span>
                        <span class="mt-2" style="font-size: 0.95rem;"><?php echo esc_html($item); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
