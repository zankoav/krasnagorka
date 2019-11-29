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
    <title>Бронирование</title>
    <link rel="stylesheet" href="<?= $assets->css('booking'); ?>">
</head>
<body>
<script>
    const model = `<?=$bookingModel;?>`;
</script>
<script src="<?= $assets->js('booking'); ?>"></script>
</body>
</html>

