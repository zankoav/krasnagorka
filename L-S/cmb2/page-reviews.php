<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }

function cmb2_reviews_page() {

    $prefix = 'mastak_reviews_';

    /**
     * Registers options page menu item and form.
     */
    $cmb_options = new_cmb2_box(array(
        'id'           => $prefix . 'page',
        'title'        => esc_html__('Настройки страницы отзывов', 'krasnagorka'),
        'object_types' => array('options-page'),
        /*
         * The following parameters are specific to the options-page box
         * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
         */
        'option_key'   => 'mastak_reviews_appearance_options',
        // The option key and admin menu page slug.
        // 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
        // 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
        'parent_slug'  => 'edit.php?post_type=page',
        // Make options page a submenu item of the themes menu.
        // 'capability'      => 'manage_options', // Cap required to view options-page.
        // 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
        // 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
        // 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
        // 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
        // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
        // 'message_cb'      => 'yourprefix_options_page_message_callback',
    ));

    $cmb_options->add_field(array(
        'name' => __('Картинка в шапке', 'krasnagorka'),
        'desc' => __('Картинка в шапке (2736 x 710)', 'krasnagorka'),
        'id'   => $prefix . 'image',
        'type' => 'file',
    ));

    $cmb_options->add_field(array(
        'name' => __('Заголовок при успешной отправке комментария', 'krasnagorka'),
        'id'   => 'title_success',
        'type' => 'text',
    ));

    $cmb_options->add_field(array(
        'name' => __('Подзаголовок при успешной отправке комментария', 'krasnagorka'),
        'id'   => 'subtitle_success',
        'type' => 'textarea_small',
    ));

    $cmb_options->add_field(array(
        'name' => __('Отображать слайдер с отзывами', 'krasnagorka'),
        'id'   => 'reviews_slider_show',
        'type' => 'checkbox',
    ));

}

add_action('cmb2_admin_init', 'cmb2_reviews_page');