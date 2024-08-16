<?php

function discounts_shortcodes()
{
    return wpautop(get_option('mastak_price_appearance_options')['mastak_price_submenu_big_text']);
}

add_shortcode('discounts', 'discounts_shortcodes');
