<?php
    /**
     *
     * Template Name: LS Главная
     *
     */
    $model=(new LS_Model())->initModel();
    $currency=new LS_Currency;

    get_template_part('/LS/backend/templates/header',$model->devise,$model);
?>
    <main class="main"><?=$currency->changePrice(100)?></main>
    <footer class="footer">Footer</footer>
        <script ><?=$model->objContent->jsContent?></script>
    </body>
</html>
