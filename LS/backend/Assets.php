<?php
    class Assets {

        private static $assets;

        private static function set_assets() {
            $path         = get_template_directory_uri() . "/src/assets.json";
            $content      = file_get_contents($path);
            self::$assets = json_decode($content, true);
        }

        public function css($name) {
            self:: set_assets();
            return self::$assets[$name]['css'];
        }

        public function js($name) {
            self:: set_assets();
            return self::$assets[$name]['js'];
        }
    }