<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view");
    $sub_title_1 = get_option('mastak_opportunities_appearance_options')['mastak_opportunity_submenu_header_sub_title_1'];
    $sub_title_2 = get_option('mastak_opportunities_appearance_options')['mastak_opportunity_submenu_header_sub_title_2'];
?>


    <section class="b-bgc-wrapper">
        <section class="b-container header-title">
            <h2 class="header-title__subtitle"><?= $sub_title_1; ?></h2>
        </section>
        <div class="b-container">
            <div class="swiper-container opportunities opportunities--js">
                <div class="swiper-wrapper opportunities__wrapper">
                    <?php
                        $added_start = true;

                        while (have_posts()) :
                        the_post();
                        if ($added_start and "added" == get_post_meta(get_the_ID(), "mastak_opportunity_added_opportunity", true)) : ?>

                </div>
                <div class="swiper-pagination opportunities__pagination"></div>
            </div>
        </div>
        <?php get_template_part("mastak/views/opportunities", "by-default"); ?>
        <section class="b-container header-title">
            <h2 class="header-title__subtitle"><?= $sub_title_2; ?></h2>
        </section>
        <div class="b-container">
            <div class="swiper-container opportunities opportunities--js">
                <div class="swiper-wrapper opportunities__wrapper">
                    <?php
                        $added_start = false;
                        endif;
                        get_template_part("mastak/views/opportunity", "small");
                        endwhile;
                        wp_reset_postdata();
                    ?>
                </div>
                <div class="swiper-pagination opportunities__pagination"></div>
            </div>
        </div>
    </section>


    <!--			<div class="show-more show-more--opportunities">-->
    <!--				<div class="show-more__button">-->
    <!--					<div class="show-more__dote"></div>-->
    <!--					<div class="show-more__dote"></div>-->
    <!--					<div class="show-more__dote"></div>-->
    <!--				</div>-->
    <!--				<span class="show-more__title">Показать еще</span>-->
    <!--			</div>-->

    <section class="b-bgc-wrapper padding-b-1">
        <?php
            if (is_active_sidebar('opportunities-content')) {
                dynamic_sidebar('opportunities-content');
            };
        ?>
    </section>
<?php

    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>