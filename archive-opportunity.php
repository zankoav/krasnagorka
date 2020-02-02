<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');
get_template_part("mastak/views/header", "small-view");
?>
<section class="b-bgc-wrapper">
	<?php
    get_template_part("mastak/views/opportunity/default");
    get_template_part("mastak/views/opportunities", "by-default");
    get_template_part("mastak/views/opportunity/added");
    ?>
</section>
<section class="b-bgc-wrapper padding-b-1">
	<?php
    if (is_active_sidebar('opportunities-content')) {
        dynamic_sidebar('opportunities-content');
    }
    ?>
</section>
<?php
get_template_part("mastak/views/reviews", "view");
get_template_part("mastak/views/footer", "view");
get_footer('mastak');
?>