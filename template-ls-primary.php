<?php
    /**
     *
     * Template Name: LS Главная
     *
     */
    
    require_once __DIR__ . '/LS/backend/index.php';

    get_template_part('/LS/backend/templates/header',$model->devise,$model);
?>
    <main class="main">Main</main>
    <footer class="footer">Footer</footer>
        <script ><?=$model->objContent->jsContent?></script>
    </body>
</html>
