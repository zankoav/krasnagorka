<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');
get_template_part("mastak/views/header", "small-view");
$subtitle_3 = get_option( 'mastak_opportunities_appearance_options' )['mastak_opportunity_submenu_header_sub_title_3'];
?>
<section class="b-bgc-wrapper">
	<?php
    get_template_part("mastak/views/opportunity/default");
    get_template_part("mastak/views/opportunities", "by-default");
    get_template_part("mastak/views/opportunity/added");
    ?>
</section>
<section class="b-bgc-wrapper padding-b-1">
    <div class="b-container content-text">
        <div class="header-title">
            <h2 class="header-title__subtitle"><?=$subtitle_3 ?></h2>
        </div>
        <div class="textwidget">
            <?= wpautop(get_option( 'mastak_opportunities_appearance_options' )['mastak_opportunity_submenu_big_text']);?>
        </div>
    </div>
</section>
<?php
get_template_part("mastak/views/reviews", "view");
get_template_part("mastak/views/footer", "view");
get_footer('mastak');
?>