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
                    'value' => 'fb',
                    'url'   => $this->themeOptions['mastak_theme_options_facebook'],
                ],
                [
                    'value' => 'ok',
                    'url'   => $this->themeOptions['mastak_theme_options_odnoklassniki'],
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
                    'value' => 'telegram',
                    'url'   => $this->themeOptions['mastak_theme_options_telegram'],
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

    public function getWeather()
    {

        $weatherStr = get_option('krasnagorka_weather');

        if (!empty($weatherStr)) {
            $weatherArray = json_decode($weatherStr, true);
            if ($weatherArray['day'] != date('w')) {
                return $this->updateWeather();
            } else {
                return $weatherArray;
            }
        } else {
            return $this->updateWeather();
        }
        return $this->updateWeather();
    }

    private function updateWeather()
    {
        $api     = "https://api.darksky.net/forecast/81b61e0936068afa7f3b5d5443c9f690/55.773202,27.072710?lang=ru&exclude=minutely,hourly,flags,alerts&units=auto";
        $weather = json_decode(file_get_contents($api), true);
        $result  = [];
        if (!empty($weather) and isset($weather["daily"]) and isset($weather["daily"]["data"])) {

            $days   = $weather["daily"]["data"];
            $result = [
                'day'         => date('w', $days[1]["time"]),
                'temperature' => round($days[1]["temperatureMax"]),
                'icon'        => "https://darksky.net/images/weather-icons/" . $days[1]["icon"] . ".png",
                'description' => $days[1]["summary"],
                'firstDay'    => [
                    'day'  => $this->DAYS[date('w', $days[2]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[2]["icon"] . ".png"
                ],
                'secondDay'   => [
                    'day'  => $this->DAYS[date('w', $days[3]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[3]["icon"] . ".png"
                ],
                'thirdDay'    => [
                    'day'  => $this->DAYS[date('w', $days[4]["time"])],
                    'icon' => "https://darksky.net/images/weather-icons/" . $days[4]["icon"] . ".png"
                ]
            ];
        }
        update_option('krasnagorka_weather', json_encode($result));
        return $result;
    }

}