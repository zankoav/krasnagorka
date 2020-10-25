<?php
    /**
     *
     * Template Name: Payed Success
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

    $options            = get_option('mastak_theme_options');
    $email              = $options['mastak_theme_options_email'];
    $life               = $options['mastak_theme_options_life'];
    $a1             = $options['mastak_theme_options_a1'];
    $mts                = $options['mastak_theme_options_mts'];
    $coordinate         = $options['mastak_theme_options_coordinate'];
    $address            = $options['mastak_theme_options_address'];
    $schema_houses_id   = $options['mastak_theme_options_schema_id'];
    $schema_services_id = $options['mastak_theme_options_schema_2_id'];

    $instagramm        = $options['mastak_theme_options_instagram'];
    $facebook          = $options['mastak_theme_options_facebook'];
    $odnoklassniki     = $options['mastak_theme_options_odnoklassniki'];
    $vk                = $options['mastak_theme_options_vkontakte'];
    $youtobe           = $options['mastak_theme_options_youtube'];
    $image_size_schema = wp_is_mobile() ? 'map_iphone_5' : 'map_laptop';


?>
    <section class="b-container b-py-2">
        <?= generateCheck($_GET['wsb_order_num']);?>
    </section>

<?php

    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>