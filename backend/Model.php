<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 10/28/19
     * Time: 9:27 AM
     */

    class Model {

        private $baseModel;

        public function __construct() {
            $this->baseModel = get_option('mastak_theme_options');
        }

        public function getFooterBottom() {
            $footer_logo_id  = $this->baseModel['footer_logo_id'];
            $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo')[0];
            $unp = wpautop($this->baseModel['mastak_theme_options_unp']);
            $unp = str_replace("\n", "", $unp);

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

        public function getBookingModel() {

            $houseId = $_GET['houseId'];
            $houseName = null;

            if(isset($houseId)){

                $post = get_post($houseId);
                if(!empty($post) and $post->post_type === 'house'){
                    $houseName = $post->post_title;
                }else{
                    $this->redirect_to_404();
                }
            }else{
                $this->redirect_to_404();
            }

            $result = [
                'mainContent' => [
                    "houseName" => $houseName,
                ],
                "footerBottom" => $this->getFooterBottom()
            ];

            return json_encode($result);
        }

        private function redirect_to_404(){
            global $wp_query;
            $wp_query->set_404();
            status_header( 404 );
            get_template_part( 404 );
            exit();
        }
    }