<?php

/**
 * 
 *
 * Template Name: Taplink
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

function getMenuItems($menuId)
{
    $menuItemsChildren = [];
    $menuItemsParents  = [];
    $items             = wp_get_nav_menu_items($menuId);
    foreach ($items as $item) {
        $styles = [];
        $bgcMeta = get_post_meta($item->ID, 'test_color_field', true);
        if (!empty($bgcMeta) && $bgcMeta != '#000000') {
            $styles["background-color"] = $bgcMeta;
            $styles["box-shadow"] = "0 2px 4px 0 $bgcMeta" . "77";
        } else {
            $styles["background-color"] = "#d0021b";
            $styles["box-shadow"] = "0 2px 4px 0 $bgcMeta" . "77";
        }

        $styleStr = '';
        foreach ($styles as $key => $value) {
            $styleStr .= "$key:$value;";
        }

        if ($item->menu_item_parent == 0) {
            $menuItemsParents[$item->ID] = [
                'key'   => $item->ID,
                'label' => $item->title,
                'href'  => $item->url,
                'style' => $styleStr
            ];
        } else {
            $menuItemsChildren[] = [
                'key'    => $item->ID,
                'label'  => $item->title,
                'href'   => $item->url,
                'parent' => $item->menu_item_parent,
                'style' => $styleStr
            ];
        }
    }

    foreach ($menuItemsChildren as $child) {
        if (empty($menuItemsParents[$child['parent']]['subItems'])) {
            $menuItemsParents[$child['parent']]['subItems'] = [$child];
        } else {
            $menuItemsParents[$child['parent']]['subItems'][] = $child;
        }
    }
    return array_values($menuItemsParents);
}

$themeOptions = get_option('mastak_theme_options');
$one_day  = 24 * 60 * 60; //seconds
$time_naw = time();

$eventsQuery = new WP_Query;
$events = $eventsQuery->query(
    [
        'post_type'  => 'event',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'mastak_event_date_finish',
                'value'   => $time_naw - $one_day,
                'compare' => '>'
            ),
            array(
                'key'     => 'mastak_event_hide_early',
                'compare' => 'NOT EXISTS'
            )
        ),
        'meta_key'   => 'mastak_event_order',
        'orderby'    => 'meta_value_num',
        'order'      => 'ASC'
    ]
);

$eventsModel = [];

foreach ($events as $event) {
    $eventId = $event->ID;
    $start = get_post_meta($eventId, 'mastak_event_date_start', true);
    $end = get_post_meta($eventId, 'mastak_event_date_finish', true);
    $imageId = get_post_thumbnail_id($eventId);
    $imgLink = wp_get_attachment_image_url($imageId, 'welcome_tab_iphone_5');
    $mainImgLink = get_post_meta($eventId, "mastak_event_taplink_image", true);
    $imgUrl = empty($mainImgLink) ? $imgLink : $mainImgLink;
    $eventsModel[] = [
        'title' => get_the_title($eventId),
        'price' => get_post_meta($eventId, "mastak_event_price", true),
        'hide_date' => get_post_meta($eventId, "mastak_event_hide_date", true) == 'on',
        'price_description' => get_post_meta($eventId, "mastak_event_price_subtitle", true),
        'date_start' => intval($start) * 1000,
        'date_end' => intval($end) * 1000,
        'link' => get_the_permalink($eventId),
        'img' =>  $imgUrl,
    ];
}


$pageModel = [
    'weather' => get_weather(),
    'menu' => getMenuItems(45),
    'info' => [
        'a1'      => $themeOptions['mastak_theme_options_a1'],
        'mts'     => $themeOptions['mastak_theme_options_mts'],
        'life'    => $themeOptions['mastak_theme_options_life'],
        'email'   => $themeOptions['mastak_theme_options_email'],
        'time'    => $themeOptions['mastak_theme_options_time'],
        'weekend' => $themeOptions['mastak_theme_options_weekend']
    ],
    "socials" => [
        [
            'value' => 'insta',
            'url'   => $themeOptions['mastak_theme_options_instagram'],
        ],
        [
            'value' => 'tiktok',
            'url'   => $themeOptions['mastak_theme_options_tiktok'],
        ],
        [
            'value' => 'telegram',
            'url'   => $themeOptions['mastak_theme_options_telegram'],
        ],
        [
            'value' => 'vk',
            'url'   => $themeOptions['mastak_theme_options_vkontakte'],
        ],
        [
            'value' => 'youtube',
            'url'   => $themeOptions['mastak_theme_options_youtube'],
        ],
        [
            'value' => 'fb',
            'url'   => $themeOptions['mastak_theme_options_facebook'],
        ],
        [
            'value' => 'ok',
            'url'   => $themeOptions['mastak_theme_options_odnoklassniki'],
        ]
    ],
    'events' => $eventsModel
];

$model = json_encode($pageModel);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= get_site_icon_url(); ?>" type="image/x-icon">
    <title><?= get_the_title(); ?></title>
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/lwc/frontend/fonts/AvenirNextCyr/fonts.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <script>
        const model = `<?= $model; ?>`;
    </script>
    <script src="<?= $assets->js('taplink'); ?>"></script>
</body>

</html>