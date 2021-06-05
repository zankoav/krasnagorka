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

    $options = get_option('mastak_home_appearance_options');
    $portfolio_slider       = $options['portfolio_slider'];
    $portfolio_slider_delay = $options['portfolio_slider_delay'];

    $test_title        = $options['mastak_home_get_test_title'];
    $test_description  = $options['mastak_home_get_test_description'];
    $test_button_title = $options['mastak_home_get_test_button_name'];
    $test_button_url   = $options['mastak_home_get_test_button_url'];
    $test_image        = $options['mastak_home_parallax_image'];

    $subtitle_1 = $options['mastak_home_subtitle_1'];
    $subtitle_2 = $options['mastak_home_subtitle_2'];

    $need_more_title = $options['mastak_home_need_more_title'];
    $need_more_description = $options['mastak_home_need_more_description'];
    $need_more_link_title = $options['mastak_home_need_more_link_title'];
    $need_more_link = $options['mastak_home_need_more_link'];

    $opportunities_ids   = $options['opportunity_home'];
    $opportunities_array = [];
    foreach ((array)$opportunities_ids as $key => $entry) {

        $opportunityId = null;

        if (isset($entry['main_opportunity'])) {
            $opportunityId = esc_html($entry['main_opportunity']);
        }

        if (!empty($opportunityId)) {
            $opportunities_array[] = $opportunityId;
        }
    }

    $opportunities_query = new WP_Query(
        array(
            'post_type' => 'opportunity',
            'post__in'  => $opportunities_array,
            'orderby' => 'post__in'
        )
    );

?>
<div class="b-container more-questions b-mt-2">
    <div class="more-questions__wrapper">
        <div class="more-questions__inner">
            <p class="more-questions__title"><?=$need_more_title?></p>
            <p class="more-questions__description ta-c"><?=$need_more_description?></p>
            <div class="ta-c">
                <a href="<?=$need_more_link?>" target="_blank" class="more-questions__submit"><?=$need_more_link_title?></a>
            </div>
        </div>
    </div>
</div>
    
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
                             src="<?= wp_get_attachment_image_url($itemImageId, $image_size) ?>"
                             srcset="<?= wp_get_attachment_image_srcset($itemImageId, $image_size) ?>"
                             sizes="<?= wp_get_attachment_image_sizes($itemImageId, $image_size) ?>">

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
