<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');
get_template_part("mastak/views/header", "small-view");

$one_day  = 24 * 60 * 60; //seconds
$time_naw = time();

$subtitle_1 = get_option('mastak_event_appearance_options')['subtitle_1'];
$subtitle_2 = get_option('mastak_event_appearance_options')['subtitle_2'];

?>

<section class="b-container header-title">
	<h2 class="header-title__subtitle"><?= $subtitle_1; ?></h2>
</section>

<div class="b-container">
	<div class="swiper-container opportunities opportunities--js">
		<div class="swiper-wrapper opportunities__wrapper">

			<?php

            $query_early = new WP_Query(
                [
                    'post_type'  => 'event',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'mastak_event_date_finish',
                            'value'   => $time_naw - $one_day,
                            'compare' => '>'
                        ),
                        array(
                            'key'     => 'mastak_event_hide_early',
                            'compare' => 'NOT EXISTS'
                        )
                    ),
                    'meta_key'   => 'mastak_event_order',
                    'orderby'    => 'meta_value_num',
                    'order'      => 'ASC'
                ]
            );

            while ($query_early->have_posts()) {
                $query_early->the_post();
                get_template_part('mastak/views/single/single', 'opportunity');
            }
            wp_reset_postdata();
            ?>
		</div>
		<div class="swiper-pagination opportunities__pagination"></div>
	</div>
</div>

<?php get_template_part("mastak/views/events", "slider"); ?>

<section class="b-container header-title">
	<h2 class="header-title__subtitle"><?= $subtitle_2; ?></h2>
</section>

<div class="b-container last-events">
	<div class="swiper-container last-events__swiper">
		<div class="swiper-wrapper last-events__wrapper">
			<?php

            $query_last = new WP_Query(
                [
                    'post_type'  => 'event',
                    'meta_query' => array(
                        array(
                            'key'     => 'mastak_event_date_finish',
                            'value'   => $time_naw - $one_day,
                            'compare' => '<='
                        )
                    )
                ]
            );
            while ($query_last->have_posts()) {
                $query_last->the_post();
                get_template_part('mastak/views/single/single', 'last-events');
            }
            ?>
		</div>
	</div>
	<div class="swiper-button-next last-events__button-next"></div>
	<div class="swiper-button-prev last-events__button-prev"></div>
</div>

<div class="b-container">
	<div class="b-light-line b-mt-3"></div>
</div>


<section class="b-container big-text">
    <div class="big-text__container content-text">
        <section class="header-title">
            <h2 class="header-title__subtitle"><?=get_option( 'mastak_event_appearance_options' )['mastak_event_submenu_big_text_title']?></h2>
        </section>
        <div class="textwidget">
            <?= wpautop(get_option( 'mastak_event_appearance_options' )['mastak_event_submenu_big_text']);?>
        </div>
    </div>
    <div class="show-more">
        <div class="show-more__button">
            <div class="show-more__dote"></div>
            <div class="show-more__dote"></div>
            <div class="show-more__dote"></div>
        </div>
        <span class="show-more__title">Показать еще</span>
    </div>
</section>

<?php
get_template_part("mastak/views/reviews", "view");
get_template_part("mastak/views/footer", "view");
get_footer('mastak');

?>