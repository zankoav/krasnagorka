<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header('mastak');

$current_season_id = get_option('mastak_theme_options')['current_season'];

$price_byn = (int) get_post_meta($current_season_id, "house_price_" . get_the_ID(), true);
$price     = get_current_price($price_byn);
$isTerem   = get_post_meta(get_the_ID(), "mastak_house_is_it_terem", true);
$subtitle  = get_post_meta(get_the_ID(), "mastak_house_subtitle", true);

if ($isTerem) {
    $terem_options = get_option('mastak_terem_appearance_options');
    $galleries     = $terem_options['gallary'];
    $kalendars     = $terem_options['kalendar'];
}

if (!$isTerem) {
    $calendarShortCode =  get_post_meta(get_the_ID(), "mastak_house_calendar", true);
    $calendarId = getCalendarId($calendarShortCode);
}

global $kgCooke;
$currency_name = $kgCooke->getCurrnecy()["currency_selected"];
$isEmployment  = isset($_GET['employment']);
$size          = wp_is_mobile() ? 'welcome_tab_iphone_5' : 'welcome_tab_laptop';

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       T
<?php endwhile;
endif; // end of the loop.
?>
<?php get_footer('mastak'); ?>