<?php
    class LS_Assets {

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
        public static function css() {
            self::checkDevice();
            self::setAssets();
            return self::$assets[self::$name]['css'];
        }
        public static function js() {
            self::checkDevice();
            self::setAssets();
            return self::$assets[self::$name]['js'];
        }
        public static function cssContent(){
            $patch=get_site_url().self::css();
            $cssContent=file_get_contents($patch);
            return $cssContent;
        }
        public static function jsContent(){
            $patch=get_site_url().self::js();
            $jsContent=file_get_contents($patch);
            return $jsContent;
       }
    }