<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 10/28/19
     * Time: 9:27 AM
     */

    class Model {

        private $baseModel;
        private $DAYS = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб' ];

        public function __construct() {
            $this->baseModel = get_option('mastak_theme_options');
        }

        public function getPopupContacts() {
            $options = $this->baseModel;
            return [
                'velcome' => $options['mastak_theme_options_velcome'],
                'mts'     => $options['mastak_theme_options_mts'],
                'life'    => $options['mastak_theme_options_life'],
                'email'   => $options['mastak_theme_options_email'],
                'time'    => $options['mastak_theme_options_time'],
                'weekend' => $options['mastak_theme_options_weekend'],
            ];
        }

        private function updateWeather(){
            $api     = "https://api.darksky.net/forecast/81b61e0936068afa7f3b5d5443c9f690/55.773202,27.072710?lang=ru&exclude=minutely,hourly,flags,alerts&units=auto";
            $weather = json_decode(file_get_contents($api), true);
            $result  = [];
            if (!empty($weather) and isset($weather["daily"]) and isset($weather["daily"]["data"])) {

                $days  = $weather["daily"]["data"];
                $result = [
                    'day' => date( 'w',$days[1]["time"]),
                    'temperature' => round($days[1]["temperatureMax"]),
                    'icon'        => "https://darksky.net/images/weather-icons/" . $days[1]["icon"] . ".png",
                    'description' => $days[1]["summary"],
                    'firstDay'    => [
                        'day'  => $this->DAYS[date( 'w',$days[2]["time"])],
                        'icon' => "https://darksky.net/images/weather-icons/" . $days[2]["icon"] . ".png"
                    ],
                    'secondDay'   => [
                        'day'  => $this->DAYS[date( 'w',$days[3]["time"])],
                        'icon' => "https://darksky.net/images/weather-icons/" . $days[3]["icon"] . ".png"
                    ],
                    'thirdDay'    => [
                        'day'  => $this->DAYS[date( 'w',$days[4]["time"])],
                        'icon' => "https://darksky.net/images/weather-icons/" . $days[4]["icon"] . ".png"
                    ]
                ];
            }
            update_option( 'krasnagorka_weather', json_encode( $result ) );
            return $result;
        }

        public function getWeather() {
            $weatherStr = get_option( 'krasnagorka_weather' );
            if ( ! empty( $weatherStr ) ) {
                $weatherArray = json_decode( $weatherStr, true );
                if ( $weatherArray === null or ( $weatherArray['day'] < date( 'w' ) ) ) {
                    return $this->updateWeather();
                } else {
                    return $weatherArray;
                }
            } else {
                return $this->updateWeather();
            }
            return $this->updateWeather();
        }

        public function getMainMenu() {
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

        public function getFooterBottom() {
            $footer_logo_id  = $this->baseModel['footer_logo_id'];
            $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo')[0];
            $unp             = wpautop($this->baseModel['mastak_theme_options_unp']);
            $unp             = str_replace("\n", "", $unp);

            return [
                "logo"    => $footer_logo_src,
                'unp'     => $unp,
                "socials" => [
                    [
                        'value' => 'insta',
                        'url'   => $this->baseModel['mastak_theme_options_instagram'],
                    ],
                    [
                        'value' => 'fb',
                        'url'   => $this->baseModel['mastak_theme_options_facebook'],
                    ],
                    [
                        'value' => 'ok',
                        'url'   => $this->baseModel['mastak_theme_options_odnoklassniki'],
                    ],
                    [
                        'value' => 'vk',
                        'url'   => $this->baseModel['mastak_theme_options_vkontakte'],
                    ],
                    [
                        'value' => 'youtube',
                        'url'   => $this->baseModel['mastak_theme_options_youtube'],
                    ]
                ]
            ];

        }

        public function getCurrencies() {

            return [
                'byn' => 1,
                'rur' => get_option('rur_currency'),
                'usd' => get_option('usd_currency'),
                'eur' => get_option('eur_currency')
            ];
        }

        public function getBookingModel() {

            $bookingId = $_GET['booking'];
            $dateFrom = $_GET['from'];
            $dateTo = $_GET['to'];
            $title     = null;
            $type      = null;

            if (isset($bookingId)) {

                $post = get_post($bookingId);
                if (!empty($post) and ($post->post_type === 'house' or $post->post_type === 'event')) {
                    $title = str_replace("\"", "\\\"", $post->post_title);
                    if ($post->post_type === 'house') {
                        $type = 'Домик:';
                    } else if ($post->post_type === 'event') {
                        $type = 'Мероприятие:';
                    }
                } else {
                    $this->redirect_to_404();
                }
            } else {
                $this->redirect_to_404();
            }

            $pageBannerSrc = get_the_post_thumbnail_url(get_the_ID(), wp_is_mobile() ? 'header_tablet_p' : 'header_laptop_hd');

            $result = [
                'mainMenu'      => $this->getMainMenu(),
                'weather'       => $this->getWeather(),
                'currencies'    => $this->getCurrencies(),
                'pageTitle' => get_the_title(),
                'pageBannerSrc' => $pageBannerSrc,
                'popupContacts' => $this->getPopupContacts(),
                'mainContent'   => [
                    "title"         => $title,
                    "type"          => $type,
                    "contractOffer" => $this->baseModel['contract_offer']
                ],
                "footerBottom"  => $this->getFooterBottom()
            ];

            if(!empty($dateFrom) and !empty($dateTo)){
                $result['dateFrom'] = $dateFrom;
                $result['dateTo'] = $dateTo;
            }

            return json_encode($result);
        }

        private function redirect_to_404() {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            get_template_part(404);
            exit();
        }
    }