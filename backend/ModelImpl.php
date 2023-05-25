<?php

namespace LsModel;

use Ls\Wp\Log as Log;

class ModelImpl
{
    protected $themeOptions;
    protected $DAYS = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

    public function __construct()
    {
        $this->themeOptions = get_option('mastak_theme_options');
    }

    // public function getPopupContacts()
    // {
    //     return [
    //         'a1'      => $this->themeOptions['mastak_theme_options_a1'],
    //         'mts'     => $this->themeOptions['mastak_theme_options_mts'],
    //         'life'    => $this->themeOptions['mastak_theme_options_life'],
    //         'email'   => $this->themeOptions['mastak_theme_options_email'],
    //         'time'    => $this->themeOptions['mastak_theme_options_time'],
    //         'weekend' => $this->themeOptions['mastak_theme_options_weekend']
    //     ];
    // }

    // public function getMainMenu()
    // {
    //     $menuItemsChildren = [];
    //     $menuItemsParents  = [];
    //     $items             = wp_get_nav_menu_items(3);
    //     foreach ($items as $item) {
    //         if ($item->menu_item_parent == 0) {
    //             $menuItemsParents[$item->ID] = [
    //                 'key'   => $item->ID,
    //                 'label' => $item->title,
    //                 'href'  => $item->url,
    //             ];
    //         } else {
    //             $menuItemsChildren[] = [
    //                 'key'    => $item->ID,
    //                 'label'  => $item->title,
    //                 'href'   => $item->url,
    //                 'parent' => $item->menu_item_parent
    //             ];
    //         }
    //     }

    //     foreach ($menuItemsChildren as $child) {
    //         if (empty($menuItemsParents[$child['parent']]['subItems'])) {
    //             $menuItemsParents[$child['parent']]['subItems'] = [$child];
    //         } else {
    //             $menuItemsParents[$child['parent']]['subItems'][] = $child;
    //         }
    //     }
    //     return array_values($menuItemsParents);
    // }

    // public function getFooterBottom()
    // {
    //     $footer_logo_id  = $this->themeOptions['footer_logo_id'];
    //     $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo')[0];
    //     $unp             = wpautop($this->themeOptions['mastak_theme_options_unp']);
    //     $unp             = str_replace("\n", "", $unp);

    //     return [
    //         "logo"    => $footer_logo_src,
    //         'unp'     => $unp,
    //         "socials" => [
    //             [
    //                 'value' => 'insta',
    //                 'url'   => $this->themeOptions['mastak_theme_options_instagram'],
    //             ],
    //             [
    //                 'value' => 'fb',
    //                 'url'   => $this->themeOptions['mastak_theme_options_facebook'],
    //             ],
    //             [
    //                 'value' => 'ok',
    //                 'url'   => $this->themeOptions['mastak_theme_options_odnoklassniki'],
    //             ],
    //             [
    //                 'value' => 'vk',
    //                 'url'   => $this->themeOptions['mastak_theme_options_vkontakte'],
    //             ],
    //             [
    //                 'value' => 'youtube',
    //                 'url'   => $this->themeOptions['mastak_theme_options_youtube'],
    //             ],
    //             [
    //                 'value' => 'telegram',
    //                 'url'   => $this->themeOptions['mastak_theme_options_telegram'],
    //             ]
    //         ]
    //     ];
    // }

    // public function getCurrencies()
    // {

    //     return [
    //         'byn' => 1,
    //         'rur' => get_option('rur_currency'),
    //         'usd' => get_option('usd_currency'),
    //         'eur' => get_option('eur_currency')
    //     ];
    // }
}