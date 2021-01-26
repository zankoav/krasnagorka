<?php
/**
     *
     * Template Name: LS Главная
     *
     */
    
     require_once __DIR__ . '/LS/backend/Assets.php';
?>
<!DOCTYPE html>
<html>
    <head>   
        <title> LS главная </title>
        <link rel="stylesheet" href="<?=Assets::css()?>">
    </head>
    <body>      
        <div style="color: rgb(0, 0, 255); font-size: 2em">
            Шапка сайта
        </div>    
        <div style="color: rgb(0, 110, 255); font-size: 2em"> 
            Контент
        </div>
        <div style="color: rgb(0, 0, 150); font-size: 2em">
            Подвал
        </div>
        <script type="text/javascript"  src="<?=Assets::js()?>"></script>
    </body>
</html>
