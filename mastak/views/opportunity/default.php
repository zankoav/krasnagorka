<?php
    $sub_title_1 = get_option('mastak_opportunities_appearance_options')['mastak_opportunity_submenu_header_sub_title_1'];
    $args        = array(
        'post_type'  => 'opportunity',
        'meta_query' => array(
            array(
                'key'     => 'mastak_opportunity_added_opportunity',
                'value'   => 'main'
            ),
        ),
        'meta_key'   => 'mastak_opportunity_order',
        'orderby'    => 'meta_value_num',
        'order'      => 'DESC'
    );
    $query_1       = new WP_Query($args);
?>
<section class="b-container header-title">
    <h2 class="header-title__subtitle"><?= $sub_title_1; ?></h2>
</section>
<div class="b-container">
    <div class="swiper-container opportunities opportunities--js">
        <div class="swiper-wrapper opportunities__wrapper">
            <?php
                while ($query_1->have_posts()) {
                    $query_1->next_post();
                    get_template_part("mastak/views/opportunity", "small");
                }
                wp_reset_postdata(); ?>
        </div>
        <div class="swiper-pagination opportunities__pagination"></div>
    </div>
</div>