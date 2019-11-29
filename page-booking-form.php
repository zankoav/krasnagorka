<?php

    if (!defined('ABSPATH')) {
        exit;
    }
    $bookingModel = $model->getBookingModel();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= get_site_icon_url();?>" type="image/x-icon">
    <title><?= get_the_title();?></title>
    <link rel="stylesheet" href="<?= $assets->css('booking'); ?>">
</head>
<body>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
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

    const model = `<?=$bookingModel;?>`;
</script>
<script src="<?= $assets->js('booking'); ?>"></script>
</body>
</html>

