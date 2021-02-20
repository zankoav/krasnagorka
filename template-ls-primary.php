<?php
    /**
     *
     * Template Name: LS Главная
     *
     */

    $model=(new LS_Model())->initModel();
    get_template_part('/LS/backend/templates/header',$model->devise,$model);
?>
    <main class="main"></main>
    <footer class="footer">Footer</footer>
        <script ><?=$model->objContent->jsContent?></script>
    </body>
</html>
