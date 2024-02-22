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

$pageModel = [
    'menu' => getMenuItems(45)
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