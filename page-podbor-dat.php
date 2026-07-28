<?php

    if (!defined('ABSPATH')) {
        exit;
    }
    global $assets;
    get_header('mastak');
    get_template_part("mastak/views/header", "small-view"); ?>
    <div class="b-bgc-wrapper b-py-3">
        <div class="b-container free-date-wrapper"></div>
    </div>

<?php get_template_part("mastak/views/footer", "view");?>

<script src="<?= $assets->js('free_date'); ?>"></script>

<?php get_footer('mastak');
