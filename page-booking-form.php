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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= get_site_icon_url(); ?>" type="image/x-icon">
    <title><?= get_the_title(); ?></title>
    <link rel="stylesheet" href="<?= $assets->css('booking'); ?>">
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/css/public_style.css" rel="stylesheet"/>
</head>

<body>
    <script>
    (function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-KDZSH92');

        const model = `<?= $bookingModel; ?>`;
    </script>

    <noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDZSH92" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
    
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/dist/vendor/moment.min.js' id='moment-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js' id='fullcalendar-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js' id='ru-js'></script>
    <script src="<?= $assets->js('booking'); ?>"></script>
</body>

</html>