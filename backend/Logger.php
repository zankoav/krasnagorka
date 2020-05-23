<?php
class Logger{
    public static function vdump($arr, $devOnly = false){
        
        $current_user = wp_get_current_user();
        $isDeveloper = $current_user->exists() && $current_user->user_login == "Sasha";

        if($devOnly){
            echo '<pre>';
            var_dump($arr);
            echo '</pre>';
            echo '</hr>';
            return;
        }

        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
        echo '</hr>';
    }


    public static function log($message, $devOnly = false){
        $current_user = wp_get_current_user();
        $isDeveloper = $current_user->exists() && $current_user->user_login == "Sasha";
        $file = dirname(__FILE__) . '/log';
        $time = date('d.m.Y H:i:s',time());

        if($devOnly){
            file_put_contents($file,$time . ' ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
            return;
        }
        
        file_put_contents($file,$time . ' ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

