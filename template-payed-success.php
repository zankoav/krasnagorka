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

    $wsbId = $_GET['wsb_tid'];
    $orderId = $_GET['wsb_order_num'];

    $wsbIdStore = get_post_meta($orderId, 'sbc_webpay_transaction_id', 1);

    if($wsbId != $wsbIdStore){
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 ); 
        exit();
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
<div style="background:#f8f8f8;">
    <section class="b-container b-py-2">
        <?= generateCheck($orderId, true);?>
    </section>
</div>
<?php

    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>