<?php

    if (!defined('ABSPATH')) {
        exit;
    }
    global $assets;
    get_header('mastak');
    get_template_part("mastak/views/header", "small-view"); ?>
    <div class="b-bgc-wrapper b-py-3">
        <div class="b-container free-date-wrapper"></div>
        <section class="b-container">
        <?php get_template_part('mastak/views/icons-description'); ?>
        <div class="select-helper select-helper_header">
            <img src="/wp-content/themes/krasnagorka/mastak/assets/icons/date-clicking-selecting.png"
                 class="select-helper__img" alt="Выделение дат заезда и выезда">
            <p class="select-helper__text"><?= get_option('mastak_theme_options')['calendar_settings_message_before']; ?></p>
        </div>
    </section>
    </div>

<?php get_template_part("mastak/views/footer", "view");?>

<script src="<?= $assets->js('free_date'); ?>"></script>

<?php get_footer('mastak');
