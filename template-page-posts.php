<?php
/**
 *
 * Template Name: Статьи
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');
get_template_part("mastak/views/header", "small-view");

$one_day  = 24 * 60 * 60; //seconds
$time_naw = time();

//'Последние новости';
$subtitle = get_post_meta(get_the_ID(), 'page_posts_news_title', 1);

?>

<section class="b-container header-title">
	<h2 class="header-title__subtitle"><?= $subtitle; ?></h2>
</section>

<div class="b-container">
	<div class="swiper-container opportunities opportunities--js">
		<div class="swiper-wrapper opportunities__wrapper">

			<?php

            $query_early = new WP_Query(
                [
                    'post_type'  => 'post',
                    'posts_per_page' => 4
                ]
            );

            while ($query_early->have_posts()) {
                $query_early->the_post();
                get_template_part('mastak/views/single/single', 'post');
            }
            wp_reset_postdata();
            ?>
		</div>
		<div class="swiper-pagination opportunities__pagination"></div>
	</div>
</div>
<?php

if (is_active_sidebar('news-content')) {
    dynamic_sidebar('news-content');
}

get_template_part("mastak/views/reviews", "view");
get_template_part("mastak/views/footer", "view");
get_footer('mastak');

?>