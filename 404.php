<?php

    /**
     *
     * The template for displaying 404 pages (Not Found).
     *
     */

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view"); ?>

    <div class="b-bgc-wrapper b-py-5">
        <div class="b-container">
            <p class="error-404">
                <?= get_option('mastak_theme_options')['sub_title_404']; ?></p>
        </div>
    </div>

<?php

    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');