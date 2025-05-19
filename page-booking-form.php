<?php

use LsModel\ModelFactory as ModelFactory;

if (!defined('ABSPATH')) {
    exit;
}

$bookingModel = ModelFactory::getBookingModel();
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

    <script>
        window.gtag = window.gtag || function () {}; 
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