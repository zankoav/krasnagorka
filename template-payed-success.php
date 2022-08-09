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

    $order = get_order_data($orderId);
    $templatePath = $order['prepaidType'] == 100 ? "L-S/mail/templates/tmpl-pay-full" : "L-S/mail/templates/tmpl-pay-partial";
    $template = LS_Mailer::getTemplate($templatePath, $order);
    $template = str_replace('600px', '100%', $template);
    $template = str_replace('600', '100', $template);
    $template = str_replace('w80', 'width=100', $template);

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
<style>
strong {
    font-weight: 700 !important;
}

@media (min-width : 768px) {
    .pay-container{ 
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
}
</style>
<div style="background:#f8f8f8;">
    <section class="pay-container">
        <?= $template;?>
    </section>
</div>
<?php

    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>