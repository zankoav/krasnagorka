<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view");
    $subtitle_1 = get_option('mastak_houses_appearance_options')['subtitle_1'];

?>
    <section class="b-pb-25 b-bgc-wrapper">
        <section class="b-container header-title">
            <h1 class="header-title__subtitle"><?= $subtitle_1; ?></h1>
        </section>
        <div class="b-container b-p-sm-0">
            <?php while (have_posts()) : the_post();
                get_template_part("mastak/views/house", "small");
            endwhile; ?>
        </div>
    </section>
    <div class="b-bgc-wrapper b-pb-25">
        <div class="b-container content-text">
            <div class="header-title">
                <h2 class="header-title__subtitle">ПОШАГОВАЯ ИНСТРУКЦИЯ БРОНИРОВАНИЯ ДОМИКА</h2>
            </div>
            <div class="textwidget">
                <?= wpautop(get_option( 'mastak_houses_appearance_options' )['mastak_house_submenu_big_text']);?>
            </div>
        </div>
        <?php
            if (is_active_sidebar('our-houses-content')) {
                dynamic_sidebar('our-houses-content');
            }
        ?>
    </div>
<?php
    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');
?>