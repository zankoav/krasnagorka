<?php



function calendar_seasons_action($atts)
{
    $default = array(
        'id' => 0
    );

    global $kgCooke;

    $resultAttr = shortcode_atts($default, $atts);
    $calendarId = $resultAttr['id'];
    $house = getHouseByCalendarId($calendarId);
    $seasons = show_seasons_options();
    $availableSeasons = getSeasonsForPricePage();
    $current_season_id = get_option('mastak_theme_options')['current_season'];
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];

    if ($house['terem']) {
        $current_season_byn = (float)get_post_meta($current_season_id, 'room_price_' . $calendarId, true);
    } else {
        $current_season_byn = (float)get_post_meta($current_season_id, "house_price_" . $house['id'], true);
    }

    $result = [
        $current_season_id => [
            'title' => $seasons[$current_season_id],
            'price_byn' => $current_season_byn,
            'price' => get_current_price($current_season_byn),
            'current' => true
        ]
    ];

    foreach ($availableSeasons as $season_id) {
        if ($season_id == $current_season_id) {
            continue;
        }

        if ($house['terem']) {
            $season_byn = (float)get_post_meta($season_id, 'room_price_' . $calendarId, true);
        } else {
            $season_byn = (float)get_post_meta($season_id, "house_price_" . $house['id'], true);
        }

        $result[$season_id] = [
            'title' => $seasons[$season_id],
            'price_byn' => $season_byn,
            'price' => get_current_price($season_byn),
            'current' => false
        ];
    }

    $content = '<table class="prices__table"><tbody>';
    foreach ($result as $s) {
        $content .= '<tr class="prices__row"><td class="prices__name prices__name_size_50per prices__link">' . $s['title'] . '</td><td class="prices__value"><span class="house-booking__price-per-men js-currency" data-currency="' . $currency_name . '" data-byn="' . $s["price_byn"] . '">' . $s["price"] . '</span> с человека в сутки</td></tr>';
    }
    $content .= '</tbody></table>';

    return $content;
}

add_shortcode('calendar_seasons', 'calendar_seasons_action');
