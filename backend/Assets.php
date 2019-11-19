<?php
    /**
     * Created by PhpStorm.
     * User: alexandrzanko
     * Date: 10/28/19
     * Time: 9:27 AM
     */

    class Assets {

        private $assets;

        public function __construct() {
            $path         = get_template_directory_uri() . "/src/assets.json";
            $content      = file_get_contents($path);
            $this->assets = json_decode($content, true);
        }

        public function css($name) {
            return $this->assets[$name]['css'];
        }

        public function js($name) {
            return $this->assets[$name]['js'];
        }
    }