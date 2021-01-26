<?php
    class Assets {

        private static $assets=null;
        private static $name=null;
        private static function checkDevice() {
            if (self::$assets==null){
                if (wp_is_mobile()){
                    return self::$name="main_mobile";
                }   else {
                    return self::$name="main_desktop";
                }  
            }     
        }
        private static function setAssets() {
            if (self::$assets==null){
            $path         = get_template_directory_uri() . "/LS/frontend/src/assets.json";
            $content      = file_get_contents($path);
            self::$assets = json_decode($content, true);
            }
        }
        public function css() {
            self::checkDevice();
            self::setAssets();
            return self::$assets[self::$name]['css'];
        }
        public function js() {
            self::checkDevice();
            self::setAssets();
            return self::$assets[self::$name]['js'];
        }
    }