<?php
class Logger{
    public static function vdump($arr){
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
        echo '</hr>';
    }


    public static function log($message){
        $file = dirname(__FILE__) . '/log';
        $time = date('d.m.Y H:i:s',time());
        file_put_contents($file,$time . ' ' . $message . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

