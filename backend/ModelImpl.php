<?php

namespace LsModel;

use Ls\Wp\Log as Log;

abstract class ModelImpl
{
    protected $themeOptions;
    protected $bookingOptions;
    protected $DAYS = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

    abstract protected function scenario();
    abstract protected function createModel();

    public function __construct()
    {
        $this->themeOptions = get_option('mastak_theme_options');
        $this->bookingOptions = get_option('mastak_booking_appearance_options');
    }

    public function getModel()
    {
        $model = $this->createModel();
        $model['scenario']      = $this->scenario();
        $model['mainMenu']      = $this->getMainMenu();
        $model['footerBottom']  = $this->getFooterBottom();
        $model['popupContacts'] = $this->getPopupContacts();
        $model['weather']       = get_weather();
        $model['currencies']    = $this->getCurrencies();
        $model['fier_events']   = $this->getFireEvents();
        $model['package_tour']  = $this->getPackageTours();
        return json_encode($model, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getFireEvents()
    {
        $tabId = absint($this->bookingOptions['booking_fire_events_tab'] ?? 0);

        if (
            !$tabId
            || get_post_type($tabId) !== 'event_tab'
            || get_post_status($tabId) !== 'publish'
            || get_post_meta($tabId, 'tab_type', true) !== 'type_8'
        ) {
            return [];
        }

        $events = (new \Type_8($tabId))->getItems();
        if (!is_array($events)) {
            return [];
        }

        $today = current_time('Y-m-d');
        $events = array_filter($events, function ($event) use ($today) {
            if (empty($event['calendar']) || empty($event['from']) || empty($event['to'])) {
                return false;
            }

            $dateFrom = strtotime($event['from']);
            $dateTo = strtotime($event['to']);
            if ($dateFrom === false || $dateTo === false || $dateFrom >= $dateTo) {
                return false;
            }

            $dateFrom = date('Y-m-d', $dateFrom);
            $dateTo = date('Y-m-d', $dateTo);

            return $dateFrom >= $today
                && \Booking_Form_Controller::isAvailableOrder((int) $event['calendar'], $dateFrom, $dateTo, false);
        });
        
        $terem_options = get_option('mastak_terem_appearance_options');
        $kalendars     = $terem_options['kalendar'];

        return array_values(array_map(function ($event) use ($tabId) {
            $event['tab_id'] = $tabId;
            $isTeremRoom = get_term_meta($event['calendar'], 'kg_calendars_terem', 1);
            if ($isTeremRoom) {
                $term = get_term($calendarId, 'sbc_calendars');
                $house_title = $term->name;
                foreach ($kalendars as $kalendar) {
                    if ($kalendar['title'] == $house_title) {
                        $event['image'] = $kalendar['picture'];
                        break;
                    }
                }
            }else if($event['image_id']){
                $event['image'] = wp_get_attachment_image_url($event['image_id'], 'welcome_tab_laptop');
            }
            return $event;
        }, $events));
    }

    public function getPackageTours()
    {
        $today = strtotime(current_time('Y-m-d'));
        $query = new \WP_Query([
            'post_type'      => 'event',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => 'mastak_event_date_finish',
                    'value'   => $today,
                    'compare' => '>=',
                    'type'    => 'NUMERIC',
                ],
                [
                    'key'     => 'mastak_event_link',
                    'value'   => 'package-id=',
                    'compare' => 'LIKE',
                ],
            ],
            'meta_key'       => 'mastak_event_order',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        ]);

        $events = array_filter($query->posts, function ($event) {
            $link = get_post_meta($event->ID, 'mastak_event_link', true);
            $query = wp_parse_url($link, PHP_URL_QUERY);

            if (empty($query)) {
                return false;
            }

            parse_str($query, $params);
            return !empty($params['package-id']);
        });

        return array_values(array_map(function ($event) {
            $eventId = $event->ID;

            return [
                'id'          => $eventId,
                'title'       => $event->post_title,
                'description' => get_post_meta($eventId, 'mastak_event_description', true),
                'image'       => get_the_post_thumbnail_url($eventId, 'header_tablet_l'),
                'link'        => get_permalink($eventId),
                'event_link'  => get_post_meta($eventId, 'mastak_event_link', true),
                'date_start'  => (int) get_post_meta($eventId, 'mastak_event_date_start', true),
                'date_finish' => (int) get_post_meta($eventId, 'mastak_event_date_finish', true),
                'price'       => get_post_meta($eventId, 'mastak_event_price', true),
                'price_subtitle' => get_post_meta($eventId, 'mastak_event_price_subtitle', true),
                'frame_color' => get_post_meta($eventId, 'mastak_event_frame_color', true),
                'icon'        => get_post_meta($eventId, 'mastak_event_icon', true),
            ];
        }, $events));
    }

    public function getPopupContacts()
    {
        return [
            'a1'      => $this->themeOptions['mastak_theme_options_a1'],
            'mts'     => $this->themeOptions['mastak_theme_options_mts'],
            'life'    => $this->themeOptions['mastak_theme_options_life'],
            'email'   => $this->themeOptions['mastak_theme_options_email'],
            'time'    => $this->themeOptions['mastak_theme_options_time'],
            'weekend' => $this->themeOptions['mastak_theme_options_weekend']
        ];
    }

    public function getMainMenu()
    {
        $menuItemsChildren = [];
        $menuItemsParents  = [];
        $items             = wp_get_nav_menu_items(3);
        foreach ($items as $item) {
            if ($item->menu_item_parent == 0) {
                $menuItemsParents[$item->ID] = [
                    'key'   => $item->ID,
                    'label' => $item->title,
                    'href'  => $item->url,
                ];
            } else {
                $menuItemsChildren[] = [
                    'key'    => $item->ID,
                    'label'  => $item->title,
                    'href'   => $item->url,
                    'parent' => $item->menu_item_parent
                ];
            }
        }

        foreach ($menuItemsChildren as $child) {
            if (empty($menuItemsParents[$child['parent']]['subItems'])) {
                $menuItemsParents[$child['parent']]['subItems'] = [$child];
            } else {
                $menuItemsParents[$child['parent']]['subItems'][] = $child;
            }
        }
        return array_values($menuItemsParents);
    }

    public function getFooterBottom()
    {
        $footer_logo_id  = $this->themeOptions['footer_logo_id'];
        $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo')[0];
        $unp             = wpautop($this->themeOptions['mastak_theme_options_unp']);
        $unp             = str_replace("\n", "", $unp);

        return [
            "logo"    => $footer_logo_src,
            'unp'     => $unp,
            "socials" => [
                [
                    'value' => 'insta',
                    'url'   => $this->themeOptions['mastak_theme_options_instagram'],
                ],
                [
                    'value' => 'tiktok',
                    'url'   => $this->themeOptions['mastak_theme_options_tiktok'],
                ],
                [
                    'value' => 'telegram',
                    'url'   => $this->themeOptions['mastak_theme_options_telegram'],
                ],
                [
                    'value' => 'vk',
                    'url'   => $this->themeOptions['mastak_theme_options_vkontakte'],
                ],
                [
                    'value' => 'youtube',
                    'url'   => $this->themeOptions['mastak_theme_options_youtube'],
                ],
                [
                    'value' => 'fb',
                    'url'   => $this->themeOptions['mastak_theme_options_facebook'],
                ],
                [
                    'value' => 'ok',
                    'url'   => $this->themeOptions['mastak_theme_options_odnoklassniki'],
                ]
            ]
        ];
    }

    public function getCurrencies()
    {

        return [
            'byn' => 1,
            'rur' => get_option('rur_currency'),
            'usd' => get_option('usd_currency'),
            'eur' => get_option('eur_currency')
        ];
    }
}
