<?php

    /**Ò
     *
     * Template Name: Home (redesign)
     *
     */

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "main-view");

    $portfolio_slider       = get_option('mastak_home_appearance_options')['portfolio_slider'];
    $portfolio_slider_delay = get_option('mastak_home_appearance_options')['portfolio_slider_delay'];

    $test_title        = get_option('mastak_home_appearance_options')['mastak_home_get_test_title'];
    $test_description  = get_option('mastak_home_appearance_options')['mastak_home_get_test_description'];
    $test_button_title = get_option('mastak_home_appearance_options')['mastak_home_get_test_button_name'];
    $test_button_url   = get_option('mastak_home_appearance_options')['mastak_home_get_test_button_url'];
    $test_image        = get_option('mastak_home_appearance_options')['mastak_home_parallax_image'];

    $subtitle_1 = get_option('mastak_home_appearance_options')['mastak_home_subtitle_1'];
    $subtitle_2 = get_option('mastak_home_appearance_options')['mastak_home_subtitle_2'];

    $opportunities_array = get_option('mastak_home_appearance_options')['mastak_home_opportunity_multicheckbox'];
    $opportunities_query = new WP_Query(
        array(
            'post_type' => 'opportunity',
            'post__in'  => $opportunities_array
        )
    );

?>

<section class="b-bgc-wrapper b-pb-2">
    <div class="b-container header-title">
        <h2 class="header-title__subtitle"><?= $subtitle_1; ?></h2>
    </div>
    <div class="b-container">
        <div class="swiper-container opportunities opportunities--js">
            <div class="swiper-wrapper opportunities__wrapper">
                <?php
                    while ($opportunities_query->have_posts()) {
                        $opportunities_query->the_post();
                        get_template_part("mastak/views/opportunity", "small");
                    }
                ?>
            </div>
            <div class="swiper-pagination opportunities__pagination"></div>
        </div>
        <div class="latest-projects__all">
            <a class="latest-projects__view-all" href="<?= get_post_type_archive_link('opportunity') ?>">Посмотреть все
                услуги
            </a>
        </div>
    </div>

    <div class="b-container more-questions b-mt-2">
        <div class="more-questions__wrapper">
            <div class="more-questions__inner">
                <p class="more-questions__title">Остались еще вопросы?</p>
                <p class="more-questions__description">Обсудите все детали с менеджером</p>
                <?= do_shortcode('[contact-form-7 id="9102" title="Mastak have questions" html_class="more-questions__forma"]'); ?>
            </div>
        </div>
    </div>

    <div class="b-container header-title">
        <h2 class="header-title__subtitle"><?= $subtitle_2; ?></h2>
        <span class="header-title__description">База отдыха на Браславских озерах</span>
    </div>

    <!-- Swiper -->
    <div class="swiper-container about-us-slider">
        <div class="swiper-wrapper about-us-slider__wrapper">
            <?php
                $image_size = wp_is_mobile() ? 'about_us_iphone_5' : 'about_us_laptop';

                foreach ($portfolio_slider as $item):
                    $itemImageId = $item["portfolio_image_id"];
                    ?>
                    <div class="swiper-slide about-us-slider__slide"
                         data-swiper-autoplay="<?= $portfolio_slider_delay; ?>">
                        <img class="object-fit-img"
                             src="<?= wp_get_attachment_image_url( $itemImageId, $image_size ) ?>"
                             srcset="<?= wp_get_attachment_image_srcset(  $itemImageId, $image_size ) ?>"
                             sizes="<?= wp_get_attachment_image_sizes(  $itemImageId, $image_size ) ?>">

                        <p class="about-us-slider__description">
                            <?= $item["portfolio_description"]; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
        </div>

        <div class="about-us-slider__container">
            <div class="b-container about-us-slider__container-wrapper">
                <div class="swiper-button-next about-us-slider__button-next"></div>
                <div class="swiper-button-prev about-us-slider__button-prev"></div>
            </div>
        </div>
    </div>

</section>

<!--
<section class="get-test">
    <img src="<?php //= $test_image; ?>" alt=get-test" class="get-test__image">
    <div class="get-test__content">
        <p class="get-test__title"><?php //= $test_title; ?></p>
        <p class="get-test__description"><?php //= $test_description; ?></p>
        <a href="<?php //= $test_button_url; ?>" target="_blank" class="get-test__button"><?php //= $test_button_title; ?></a>
    </div>
</section>
-->

<section class="b-bgc-wrapper">
    <?php
        if (is_active_sidebar('home-content')) {
            dynamic_sidebar('home-content');
        };
    ?>
</section>
<?php
    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');
?>
