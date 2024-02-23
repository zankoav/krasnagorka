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
        if ($item->menu_item_parent == 0) {
            $menuItemsParents[$item->ID] = [
                'key'   => $item->ID,
                'label' => $item->title,
                'href'  => $item->url,
            ];
        } else {
            $menuItemsChildren[] = [
                'key'    => $item->ID,
                'label'  => $item->title,
                'href'   => $item->url,
                'parent' => $item->menu_item_parent
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
        'date_start' => intval($start),
        'date_end' => intval($end),
        'link' => get_the_permalink($eventId),
        'img' =>  $imgUrl,
    ];
}

$pageModel = [
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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3BJFQZCBDC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-3BJFQZCBDC');
    </script>

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-85853604-1', 'auto');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');

        const model = `<?= $model; ?>`;
    </script>
    <script src="<?= $assets->js('taplink'); ?>"></script>
</body>

</html>