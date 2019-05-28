<?php
    /**
     *
     * Template Name: Map (redesign)
     *
     */

    // File Security Check
    if (!defined('ABSPATH')) {
        exit;
    }

    $price = get_current_price($price_byn);

    global $kgCooke;
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view");

    $options         = get_option('mastak_theme_options');
    $email           = $options['mastak_theme_options_email'];
    $life            = $options['mastak_theme_options_life'];
    $velcom          = $options['mastak_theme_options_velcome'];
    $mts             = $options['mastak_theme_options_mts'];
    $coordinate      = $options['mastak_theme_options_coordinate'];
    $address         = $options['mastak_theme_options_address'];
    $schema_houses_id   = $options['mastak_theme_options_schema_id'];
    $schema_services_id = $options['mastak_theme_options_schema_2_id'];

    $instagramm    = $options['mastak_theme_options_instagram'];
    $facebook      = $options['mastak_theme_options_facebook'];
    $odnoklassniki = $options['mastak_theme_options_odnoklassniki'];
    $vk            = $options['mastak_theme_options_vkontakte'];
    $youtobe       = $options['mastak_theme_options_youtube'];
    $image_size_schema = wp_is_mobile() ? 'map_iphone_5' : 'map_laptop';


?>

    <section class="b-container">
        <h2 class="header-title__subtitle b-mb-2 b-mt-3">Карта домов</h2>
        <div class="base-place b-mb-2">
            <a rel="group" href="<?= wp_get_attachment_image_url( $schema_houses_id, 'full' ); ?>" class="base-place__image fancybox image">
                <img class="base-place__image-inner" alt="Карта домов"
                     src="<?= wp_get_attachment_image_url( $schema_houses_id, $image_size_schema ) ?>"
                     srcset="<?= wp_get_attachment_image_srcset( $schema_houses_id, $image_size_schema ) ?>"
                     sizes="<?= wp_get_attachment_image_sizes(  $schema_houses_id, $image_size_schema ) ?>">
            </a>
            <div class="base-place__content">
                <?php
                    if (is_active_sidebar('map-content')) {
                        dynamic_sidebar('map-content');
                    };
                ?>
            </div>
        </div>
        <h2 class="header-title__subtitle b-mb-2 b-mt-3">Карта услуг</h2>
        <div class="base-place b-mb-2">
            <a rel="group" href="<?= wp_get_attachment_image_url( $schema_services_id, 'full' ); ?>" class="base-place__image fancybox image">
                <img class="base-place__image-inner" alt="Карта услуг"
                     src="<?= wp_get_attachment_image_url( $schema_services_id, $image_size_schema ) ?>"
                     srcset="<?= wp_get_attachment_image_srcset( $schema_services_id, $image_size_schema ) ?>"
                     sizes="<?= wp_get_attachment_image_sizes(  $schema_services_id, $image_size_schema ) ?>">
            </a>
            <div class="base-place__content">
                <?php
                    if (is_active_sidebar('map-2-content')) {
                        dynamic_sidebar('map-2-content');
                    };
                ?>
            </div>
        </div>
        <h2 class="header-title__subtitle b-mb-2">Контакты</h2>
        <div class="base-place__contacts">
            <p class="base-place__address"><?= $address; ?></p>
            <p class="base-place__coordinate">Координаты: <?= $coordinate; ?></p>
            <div class="base-place__phones">
                <div class="base-place__phones-block">
                    <p class="base-place__phone"><?= $velcom; ?></p>
                    <p class="base-place__phone"><?= $mts; ?></p>
                    <p class="base-place__phone"><?= $life; ?></p>
                </div>
            </div>
            <a href="mailto:<?= $email; ?>" class="base-place__email"><?= $email; ?></a>
            <div class="footer-bottom-left__socials footer-bottom-left__socials_map">
                <?php if (!empty($instagramm)): ?>
                    <a href="<?= $instagramm; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/insta_gray.svg"
                             alt="Instagram"
                             title="Instagram">
                    </a>
                <?php endif; ?>
                <?php if (!empty($facebook)): ?>
                    <a href="<?= $facebook; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/fb_gray.svg"
                             alt="Facebook"
                             title="Facebook">
                    </a>
                <?php endif; ?>
                <?php if (!empty($odnoklassniki)): ?>
                    <a href="<?= $odnoklassniki; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/ok_gray.svg"
                             alt="Одноклассники"
                             title="Одноклассники">
                    </a>
                <?php endif; ?>
                <?php if (!empty($vk)): ?>
                    <a href="<?= $vk; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/vk_gray.svg"
                             alt="Вконтакте"
                             title="Вконтакте">
                    </a>
                <?php endif; ?>
                <?php if (!empty($youtobe)): ?>
                    <a href="<?= $youtobe; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/youtube_gray.svg"
                             alt="Youtube"
                             title="Youtube">
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="b-light-line b-my-3 b-d-block-sm"></div>


    </section>

    <section class="b-container header-title">
        <h2 class="header-title__subtitle">Проложить маршрут</h2>
    </section>

    <section class="b-container ">
        <p class="way__subtitle">Укажите город из которого Вы планируете к нам ехать и нажмите кнопку проложить
            маршрут</p>
        <div class="way__map">
            <input id="pac-input" class="controls-routemap" type="text" placeholder="Откуда ехать?"
                   onkeypress="isEnterPressed(this.value, event)">
            <input id="pac-input-button" class="controls-routemap" type="button" value="Проложить маршрут"
                   onclick="codeAddress()">

            <div id="map-route-canvas" class="way__canvas"></div>
        </div>
    </section>

<?php

    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>