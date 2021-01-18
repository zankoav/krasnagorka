<?php
    class Assets {

        private static $assets=null;

        private static function setAssets() {
            if (self::$assets==null){
            $path         = get_template_directory_uri() . "/LS/frontend/src/assets.json";
            $content      = file_get_contents($path);
            self::$assets = json_decode($content, true);
            }
        }
        public function css($name) {
            self::setAssets();
            return self::$assets[$name]['css'];
        }
        public function js($name) {
            self::setAsets();
            return self::$assets[$name]['js'];
        }
    }