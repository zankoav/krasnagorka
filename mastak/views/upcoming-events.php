<?php
if (!defined('ABSPATH')) {
    exit;
}

$one_day  = 24 * 60 * 60; //seconds
$time_naw = time();

$subtitle_1 = get_option('mastak_event_appearance_options')['subtitle_1'];
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