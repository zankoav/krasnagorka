<?php

    /**
     *
     * Template Name: Reviews (redesign)
     *
     */

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view");
    comments_template("/mastak/views/comments.php");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');