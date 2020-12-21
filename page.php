<?php

    /**
     *
     * Template Name: Default (redesign)
     *
     */

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view"); ?>
    <div class="b-bgc-wrapper b-py-3">
        <div class="b-container big-text js-zankoav">
            <?php the_content(); ?>
        </div>
    </div>

<?php get_template_part("mastak/views/footer", "view");
    get_footer('mastak');