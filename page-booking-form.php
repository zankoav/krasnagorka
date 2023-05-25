<?php

if (!defined('ABSPATH')) {
    exit;
}
$model  = new Model();
$bookingModel = $model->getBookingModel();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= get_site_icon_url(); ?>" type="image/x-icon">
    <title><?= get_the_title(); ?></title>
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/lwc/frontend/fonts/AvenirNextCyr/fonts.css" rel="stylesheet"/>
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/css/public_style.css" rel="stylesheet"/>
</head>

<body>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3BJFQZCBDC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
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

        const model = `<?= $bookingModel; ?>`;
    </script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/dist/vendor/moment.min.js' id='moment-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js' id='fullcalendar-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js' id='ru-js'></script>
    <script src="<?= $assets->js('booking'); ?>"></script>
    <script src="<?= $assets->js('cookie'); ?>"></script>
</body>

</html>