<?php
require_once __DIR__ . '/fetch.php';
require_once __DIR__ . '/../templates/grid-realestate-view.php';

function translatePropertyType(string $tip): string {
    $mapa = [
        'Land' => 'Zemljište',
        'Business premise' => 'Poslovni prostor',
        'Apartment' => 'Stan',
        'House' => 'Kuća'
    ];

    return $mapa[$tip] ?? 'Nepoznat tip';
}

function dimedia_render_grid_view($feed_url) {
    $rawProperties = dimedia_fetch_data($feed_url);
    $preparedProperties = [];

    foreach ($rawProperties as $item) {
        $typeEng = $item['propertyType'] ?? 'Nepoznat tip';
        $typeHr = translatePropertyType($typeEng);

        $wide_area = $item['widerArea'] ?? 'Nepoznata šira lokacija';

        $locationParts = [];
        if (!empty($item['city'])) {
            $locationParts[] = $item['city'];
        }
        if (!empty($item['street'])) {
            $locationParts[] = $item['street'];
        }
        $location = !empty($locationParts) ? implode(', ', $locationParts) : 'Nepoznata lokacija';

        $images = [];
        if (!empty($item['propertyFiles']) && is_array($item['propertyFiles'])) {
            foreach ($item['propertyFiles'] as $file) {
                if (($file['collection'] ?? '') === 'photo' && !empty($file['url'])) {
                    $images[] = $file['url'];
                }
            }
        }

        $propertyTitle = $item['propertyTitle']['hr'] ?? 'Bez naslova';

        $preparedProperties[] = [
            'id'         => $item['id'] ?? 0,
            'type'       => $typeHr,
            'wide_area'  => $wide_area,
            'location'   => $location,
            'title'      => $propertyTitle,
            'price'      => $item['price'] ?? 'Cijena nije dostupna',
            'images'     => $images,
            'url'        => $item['url'] ?? '#',
            'categories' => ['izdvojeno'],
        ];
    }

    return dimedia_render_list($preparedProperties);
}

function dimedia_fetch_single_property_from_feed($feed_url, $property_id) {
    $properties = dimedia_fetch_data($feed_url);

    foreach ($properties as $item) {
        if (($item['id'] ?? null) == $property_id) {
            $typeEng = $item['propertyType'] ?? 'Nepoznat tip';
            $typeHr = translatePropertyType($typeEng);

            $wide_area = $item['widerArea'] ?? 'Nepoznata šira lokacija';

            $locationParts = [];
            if (!empty($item['city'])) {
                $locationParts[] = $item['city'];
            }
            if (!empty($item['street'])) {
                $locationParts[] = $item['street'];
            }
            $location = !empty($locationParts) ? implode(', ', $locationParts) : 'Nepoznata lokacija';

            $images = [];
            if (!empty($item['propertyFiles']) && is_array($item['propertyFiles'])) {
                foreach ($item['propertyFiles'] as $file) {
                    if (($file['collection'] ?? '') === 'photo' && !empty($file['url'])) {
                        $images[] = $file['url'];
                    }
                }
            }

            $repeatGroup = [];
            if (!empty($item['features']) && is_array($item['features'])) {
                foreach ($item['features'] as $feature) {
                    $repeatGroup[] = [
                        'title' => $feature['name']['hr'] ?? '',
                        'description' => $feature['value']['hr'] ?? '',
                    ];
                }
            }

            $preparedProperty = [
                'id'                => $item['id'] ?? 0,
                'tip_nekretnine'    => $typeHr,
                'mjesto'            => $location,
                'title'             => $item['propertyTitle']['hr'] ?? 'Bez naslova',
                'cijena'            => $item['price'] ?? 'Cijena nije dostupna',
                'slike'             => $images,
                'url'               => $item['url'] ?? '#',
                'categories'        => ['izdvojeno'],
                'kvadratura'        => $item['area'] ?? '',
                'status'            => $item['propertyStatus'] ?? '',
                'slika'             => $images[0] ?? '',
                'opis'              => $item['propertyDescription']['hr'] ?? '',
                'propertyUtility'   => $item['propertyUtility'] ?? '',
                'propertyPropertySpace' => $item['propertyPropertySpace'] ?? '',
                'propertyEquipment'=> $item['propertyEquipment'] ?? '',
                'repeat_group'      => $repeatGroup,
                'mapLatitude'          => $item['mapLatitude'] ?? '',
                'mapLongitude'         => $item['mapLongitude'] ?? '',
                'mapLocationSyncType'  => $item['mapLocationSyncType'] ?? '',
                'mapLocationSync'      => $item['mapLocationSync'] ?? '',
                'propertyAddress'      => $item['propertyAddress'] ?? '',

            ];

            return $preparedProperty;
        }
    }

    return null;
}