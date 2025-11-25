<?php

if (!defined('ABSPATH')) {
    exit;
}

use LsFactory\PaymentService as PaymentService;
use Ls\Wp\Log as Log;

require __DIR__ . '/constants.php';
// START


function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function currencyModel($value)
{
    $valueArr = explode('.', number_format($value, 2, '.', ''));
    return [
        'rub' => $valueArr[0],
        'penny' => $valueArr[1]
    ];
}

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/L-S/utils/index.php';
require __DIR__ . '/L-S/setup.php';
require __DIR__ . '/L-S/cmb2/index.php';
require __DIR__ . '/L-S/widgets/index.php';
require __DIR__ . '/L-S/models/index.php';

require __DIR__ . '/backend/Logger.php';
require __DIR__ . '/backend/Assets.php';
require __DIR__ . '/backend/CalculateImpl.php';
require __DIR__ . '/backend/PackageCalculate.php';
require __DIR__ . '/backend/PackageAdminCalculate.php';
require __DIR__ . '/backend/ModelImpl.php';
require __DIR__ . '/backend/BaseModel.php';
require __DIR__ . '/backend/PackageModel.php';
require __DIR__ . '/backend/FierModel.php';
require __DIR__ . '/backend/EventModel.php';
require __DIR__ . '/backend/ModelFactory.php';

// Factory
require __DIR__ . '/L-S/classes/index.php';
require __DIR__ . '/L-S/mail/LS_Mailer.php';

$assets = new Assets();

require __DIR__ . '/token_actions.php';
require __DIR__ . '/inc/calendar/init.php';
require __DIR__ . '/mastak/init.php';

require __DIR__ . '/LS/backend/rest/rest.php';
require __DIR__ . '/rest/rest.php';

WP_Nav_Menu_Taplink_Fields::init();


add_filter('wp_mail_content_type', 'set_html_content_type');

function set_html_content_type()
{
    return 'text/html';
}

add_filter('wp_mail_from_name', 'vortal_wp_mail_from_name');

function vortal_wp_mail_from_name($email_from)
{
    return 'info@krasnagorka.by';
}

add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
    $uri = get_template_directory_uri();
    wp_enqueue_style('admin_css', $uri  . '/admin-style.css', false, '1.0.0');

    wp_enqueue_style('events_tab_css', $uri  . '/css/tabs-event.css', false, '1.0.0');
    wp_enqueue_script('events_tab_js', $uri . '/js/tabs-event.js', array('jquery'), false, true);

    wp_enqueue_style('fires_tab_css', $uri  . '/css/tabs-fire.css', false, '1.0.0');
    wp_enqueue_script('fires_tab_js', $uri . '/js/tabs-fire.js', array('jquery'), false, true);

    wp_enqueue_style('package_css', $uri  . '/css/package-link.css', false, '1.0.0');
    wp_enqueue_script('package_js', $uri . '/js/package-link.js', array('jquery'), false, true);
}


function getOrderStatus($calendarId, $dateStart, $dateEnd)
{
    $result = false;

    $dateStart = date("Y-m-d", strtotime($dateStart));
    $dateEnd = date("Y-m-d", strtotime($dateEnd));

    if (isset($calendarId, $dateStart, $dateEnd)) {

        $ordersQuery = new WP_Query;
        $orders = $ordersQuery->query(array(
            'post_type' => 'sbc_orders',
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'sbc_calendars',
                    'terms' => [$calendarId]
                ]
            ],
            'meta_query' => array(
                array(
                    'key'     => 'sbc_order_end',
                    'value'   => $dateStart,
                    'compare' => '>=',
                )
            )
        ));

        $parseResult = [];

        foreach ($orders  as $order) {
            $orderId = $order->ID;
            $start = get_post_meta($orderId, 'sbc_order_start', true);
            $startTime = strtotime($start);
            $start = date('Y-m-d', $startTime);
            $end = get_post_meta($orderId, 'sbc_order_end', true);
            $endTime = strtotime($end);
            $end = date('Y-m-d', $endTime);

            $status = get_post_meta($orderId, 'sbc_order_select', true);
            $parseResult[] = [$start, $end, $status];
        }

        foreach ($parseResult as $r) {
            $from = $r[0];
            $to = $r[1];

            if ($dateStart >= $from and $dateStart < $to) {
                $result = $r[2];
            }

            if ($dateEnd > $from and $dateEnd <= $to) {
                $result = $r[2];
            }

            if ($dateStart < $from and $dateEnd > $to) {
                $result = $r[2];
            }
        }
    }

    return $result;
}


// for delete

if (!isset($content_width)) {
    $content_width = 1200;
}

function getHouseByCalendarId($calendarId)
{
    $result = [];
    $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1);

    $result['terem'] = $isTeremRoom;

    $houseQuery = new WP_Query;
    $args = null;
    if ($isTeremRoom) {
        $args = array(
            'post_type' => 'house',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key'     => 'mastak_house_is_it_terem',
                    'value'   =>  'on',
                    'compare' => '=',
                )
            )
        );
    } else {
        $args = array(
            'post_type' => 'house',
            'posts_per_page' => 1,
            'meta_query' => array(
                array(
                    'key'     => 'mastak_house_calendar',
                    'value'   =>  'id="' . $calendarId . '"',
                    'compare' => 'LIKE',
                )
            )
        );
    }
    $houses = $houseQuery->query($args);
    if (count($houses)) {
        $result['id'] = $houses[0]->ID;
    }

    return $result;
}




function getCalendarId($calendarShortCode)
{
    $arr = explode("\"", $calendarShortCode);
    return $arr[1];
}

function cmb2_after_form_do_js_validation($post_id, $cmb)
{
    static $added = false;

    // Only add this to the page once (not for every metabox)
    if ($added) {
        return;
    }

    $added = true;
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $form = $(document.getElementById('post'));
            $htmlbody = $('html, body');
            $toValidate = $('[data-validation]');

            if (!$toValidate.length) {
                return;
            }

            function checkValidation(evt) {
                var labels = [];
                var $first_error_row = null;
                var $row = null;

                function add_required($row) {
                    $row.css({
                        'background-color': 'rgb(255, 170, 170)'
                    });
                    $first_error_row = $first_error_row ? $first_error_row : $row;
                    labels.push($row.find('.cmb-th label').text());
                }

                function remove_required($row) {
                    $row.css({
                        background: ''
                    });
                }

                $toValidate.each(function() {
                    var $this = $(this);
                    var val = $this.val();
                    $row = $this.parents('.cmb-row');

                    if ($this.is('[type="button"]') || $this.is('.cmb2-upload-file-id')) {
                        return true;
                    }

                    if ('required' === $this.data('validation')) {
                        if ($row.is('.cmb-type-file-list')) {

                            var has_LIs = $row.find('ul.cmb-attach-list li').length > 0;

                            if (!has_LIs) {
                                add_required($row);
                            } else {
                                remove_required($row);
                            }

                        } else {
                            if (!val) {
                                add_required($row);
                            } else {
                                remove_required($row);
                            }
                        }
                    }

                });

                if ($first_error_row) {
                    evt.preventDefault();
                    alert('<?php _e('The following fields are required and highlighted below: ', 'cmb2'); ?> ' + labels.join(', '));
                    $htmlbody.animate({
                        scrollTop: ($first_error_row.offset().top - 200)
                    }, 1000);
                } else {
                    // Feel free to comment this out or remove
                    alert('submission is good!');
                }

            }

            $form.on('submit', checkValidation);


        });
    </script>
<?php
}

add_action('cmb2_after_form', 'cmb2_after_form_do_js_validation', 10, 2);

function generateCheck($orderId, $isWebSite = false)
{
    $created = get_the_date("d.m.Y", $orderId);
    $start = get_post_meta($orderId, 'sbc_order_start', 1);
    $end = get_post_meta($orderId, 'sbc_order_end', 1);
    $price = get_post_meta($orderId, 'sbc_order_price', 1);
    $leadId = get_post_meta($orderId, 'sbc_lead_id', 1);
    $calendars  = get_the_terms($orderId, 'sbc_calendars');
    $viewPath = $isWebSite ? "mastak/views/webpay/success" : "mastak/views/webpay/mail";

    $client = get_post_meta($orderId, 'sbc_order_client', 1);
    $pieces = explode(" ", $client);
    $clientId = $pieces[0];
    $phone = get_post_meta($clientId, 'sbc_client_phone', 1);
    $fio = get_the_title($clientId);
    $fio = explode("+", $fio);

    $passport = get_post_meta($orderId, 'sbc_order_passport', 1);
    $peopleCount = get_post_meta($orderId, 'sbc_order_count_people', 1);

    $calendarSlug = $calendars[0]->slug;
    $calendarId = $calendars[0]->term_id;
    $calendarShortCode = '[sbc_calendar id="' . $calendarId . '" slug="' . $calendarSlug . '"]';
    $houseLink = getHouseLinkByShortCode($calendarShortCode);

    $message = get_template_part($viewPath, null, [
        'order' => [
            'created' => $created,
            'from' => date("d.m.Y", strtotime($start)),
            'to' => date("d.m.Y", strtotime($end)),
            'price' => $price,
            'subprice' => $price,
            'passport' => $passport ?? '-',
            'fio' => $fio[0],
            'leadId' => $leadId,
            'peopleCount' => $peopleCount,
            'phone' => $phone,
            'calendarName' => $calendars[0]->name,
            'calendarLink' => $houseLink
        ]
    ]);
    return $message;
}

function generateGuestMemo()
{
    $memoLink = get_option('mastak_theme_options')['guest_memo'];

    $message = get_template_part("mastak/views/webpay/memo-guest", null, [
        'data' => [
            'memo' => $memoLink
        ]
    ]);
    return $message;
}

function getHouseLinkByShortCode($calendarShortCode)
{
    $result = null;
    $houses = get_posts(['post_type'   => 'house', 'numberposts' => -1]);

    foreach ($houses as $house) {
        $isTerem = get_post_meta($house->ID, 'mastak_house_is_it_terem', 1);
        $shortcode = get_post_meta($house->ID, 'mastak_house_calendar', 1);
        if ($result == null and $isTerem) {
            $result = get_post_permalink($house->ID);
        } else if ($shortcode == $calendarShortCode) {
            $result = get_post_permalink($house->ID);
            break;
        }
    }
    return $result;
}

function getEmailFromOrder($orderId)
{
    $client = get_post_meta($orderId, 'sbc_order_client', 1);
    $pieces = explode(" ", $client);
    $clientId = $pieces[0];
    $email = get_post_meta($clientId, 'sbc_client_email', 1);
    return $email;
}


add_filter('cron_schedules', 'cron_add_clear_intervals');
function cron_add_clear_intervals($schedules)
{
    // регистрируем 5 минутный интервал
    $schedules['five_min'] = array(
        'interval' => 60 * 5,
        'display' => 'Раз в 5 минут'
    );
    // регистрируем 1 дневный  интервал
    $schedules['one_day'] = array(
        'interval' => 60 * 60 * 12,
        'display' => 'Раз в 12 часов'
    );

    // регистрируем четверть дневного интервала
    $schedules['quarter_day'] = array(
        'interval' => 60 * 60 * 6,
        'display' => 'Раз в 6 часов'
    );
    return $schedules;
}

add_action('wp', 'kg_clear_order');
function kg_clear_order()
{
    $time = time();
    if (!wp_next_scheduled('kg_clear_order_five_min_event')) {
        wp_schedule_event($time, 'five_min', 'kg_clear_order_five_min_event');
    }

    if (!wp_next_scheduled('kg_clear_order_quarter_day_min_event')) {
        wp_schedule_event($time, 'quarter_day', 'kg_clear_order_quarter_day_min_event');
    }

    if (!wp_next_scheduled('update_current_season_per_day_event')) {
        wp_schedule_event($time, 'one_day', 'update_current_season_per_day_event');
    }

    // if (!wp_next_scheduled('kg_clear_order_1_day_min_event')) {
    //     wp_schedule_event($time, 'one_day', 'kg_clear_order_1_day_min_event'); 
    // }
}



add_action('update_current_season_per_day_event', 'update_current_season');
function update_current_season()
{
    $mastak_theme_options = get_option('mastak_theme_options');
    $today = current_datetime()->format('Y-m-d');
    $current_season_id = getSelectedSeasonId($today);
    $mastak_theme_options['current_season'] = $current_season_id;
    update_option('mastak_theme_options', $mastak_theme_options);
    Log::info('mastak_theme_options', $mastak_theme_options);
}

function getSelectedSeasonId($dateFrom)
{
    $id = null;

    $firstSeasonIntervalParams = array(
        'post_type' => 'season_interval',
        'posts_per_page' => 1,
        'meta_query' => [
            'relation' => 'OR',
            [
                'relation' => 'AND',
                [
                    'key'     => 'season_from',
                    'value'   => $dateFrom,
                    'type'    => 'DATE',
                    'compare' => '<='
                ],
                [
                    'key'     => 'season_to',
                    'value'   => $dateFrom,
                    'type'    => 'DATE',
                    'compare' => '>='
                ]
            ]
        ]
    );
    $intervalsQuery = new \WP_Query;
    $intervals = $intervalsQuery->query($firstSeasonIntervalParams);
    if (count($intervals) > 0) {
        $id = get_post_meta($intervals[0]->ID, 'season_id', 1);
    }

    return $id;
}

// add_action('kg_clear_order_1_day_min_event', 'kg_clear_orders_2');
function kg_clear_orders_2()
{

    $query = new WP_Query(
        [
            'post_type'  => 'sbc_orders',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'sbc_order_select',
                    'value'   => 'reserved',
                    'compare' => '='
                ),
                array(
                    'key'     => 'sbc_order_prepaid_source',
                    'compare' => 'EXISTS'
                )
            ),
            'date_query' => array(
                array(
                    'before'    => '2 days ago',
                    'inclusive' => true
                )
            )
        ]
    );
    $orders = $query->get_posts();

    foreach ($orders as $order) {
        $leadId = get_post_meta($order->ID, 'sbc_lead_id', 1);
        Booking_Form_Controller::clear_order($leadId);
        Booking_Form_Controller::createAmoCrmTask('Истекло время ожидания и бронь удалилась из сайта', $leadId);
        wp_delete_post($order->ID, true);
    }
}

add_action('kg_clear_order_five_min_event', 'kg_clear_orders');
function kg_clear_orders()
{

    $query = new WP_Query(
        [
            'post_type'  => 'sbc_orders',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'sbc_order_select',
                    'value'   => 'reserved',
                    'compare' => '='
                ),
                array(
                    'key'     => 'sbc_order_payment_method',
                    'value'   => 'card',
                    'compare' => '='
                )
            ),
            'date_query' => array(
                array(
                    'before'    => '25 minutes ago',
                    'inclusive' => true
                )
            )
        ]
    );
    $orders = $query->get_posts();

    foreach ($orders as $order) {
        $leadId = get_post_meta($order->ID, 'sbc_lead_id', 1);
        Booking_Form_Controller::clear_order($leadId);
        Booking_Form_Controller::createAmoCrmTask('Истекло время и бронь удалилась из сайта (100% по карте)', $leadId);
        wp_delete_post($order->ID, true);
    }
}

add_action('kg_clear_order_quarter_day_min_event', 'kg_add_remind');
function kg_add_remind()
{

    $query = new WP_Query(
        [
            'post_type'  => 'sbc_orders',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'sbc_order_select',
                    'value'   => 'reserved',
                    'compare' => '='
                ),
                array(
                    'key'     => 'sbc_remind_task',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key'     => 'sbc_order_prepaid_source',
                    'compare' => 'EXISTS'
                )
            ),
            'date_query' => array(
                array(
                    'before'    => '1 day ago',
                    'inclusive' => true
                )
            )
        ]
    );
    $orders = $query->get_posts();

    foreach ($orders as $order) {
        $leadId = get_post_meta($order->ID, 'sbc_lead_id', 1);
        Booking_Form_Controller::createAmoCrmTask('Напомнить клиенту оплатить свою бронь осталось 15 часов', $leadId);
        update_post_meta($order->ID, 'sbc_remind_task', 'Задача создана');
    }

    kg_clear_orders_2();
}

// ADD ROLE Once!
// add_role( 'basic_contributor', 'Менеджер по объектам',
//     [ 'read' => true ]
// );


// add_role('project_manager_fire',
//     'Менеджер по Горящим Предложениям',
//     array(
//         'read' => true,
//         'edit_posts' => false,
//         'delete_posts' => false,
//         'publish_posts' => false,
//         'upload_files' => true,
//     )
// );

//END */

add_action('admin_init', 'psp_add_role_caps', 999);
function psp_add_role_caps()
{

    // Add the roles you'd like to administer the custom post types
    $roles = array('project_manager_fire', 'editor', 'administrator');

    // Loop through each role and assign capabilities
    foreach ($roles as $the_role) {

        $role = get_role($the_role);

        $role->add_cap('read');
        $role->add_cap('read_event_tab');
        $role->add_cap('read_private_event_tabs');
        $role->add_cap('edit_event_tab');
        $role->add_cap('edit_event_tabs');
        $role->add_cap('edit_others_event_tabs');
        $role->add_cap('edit_published_event_tabs');
        $role->add_cap('publish_event_tabs');
        $role->add_cap('delete_others_event_tabs');
        $role->add_cap('delete_private_event_tabs');
        $role->add_cap('delete_published_event_tabs');
    }
}


require_once __DIR__ . '/menu/orders-menu-item.php';
require_once __DIR__ . '/tabs/index.php';


add_action('rest_api_init', function () {
    register_rest_route('happy/v1', '/events/', [
        'methods'  => 'GET',
        'callback' => 'app_get_happy_events',
    ]);
});

function app_get_happy_events()
{
    $result  = [
        "icon_path" => "https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/marketing/",
        "items" => []
    ];
    $args  = array(
        'post_type'      => 'event_tab',
        'post_status'    => array('publish'),
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key'     => 'tab_type',
                'value'   => 'type_10',
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            $intervalId  = get_post_meta(get_the_ID(), 'mastak_event_tab_type_10_interval', true);
            $icon    = get_post_meta(get_the_ID(), 'mastak_event_tab_type_10_icon', true);
            $description  = get_post_meta(get_the_ID(), 'mastak_event_tab_type_10_description', true);
            $start  = get_post_meta($intervalId, 'season_from', true);
            $end    = get_post_meta($intervalId, 'season_to', true);
            $dateTo = new DateTime($end);
            $dateFrom = new DateTime($start);
            $period = new DatePeriod(
                $dateFrom->modify('-1 day'),
                new DateInterval('P1D'),
                $dateTo->modify('+1 day')
            );


            foreach ($period as $key => $value) {
                $result['items'][] = array(
                    'date'  => $value->format('Y-m-d'),
                    'icon'  => $icon,
                    'description' => $description
                );
            }
        endwhile;
        wp_reset_postdata();
    endif;
    return $result;
}

function getSeasonsForPricePage()
{
    $today = current_datetime()->format('Y-m-d');
    $seasonsIntervalsParams = array(
        'post_type' => 'season_interval',
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'OR',
            [
                'relation' => 'AND',
                [
                    'key'     => 'season_from',
                    'value'   => $today,
                    'type'    => 'DATE',
                    'compare' => '<='
                ],
                [
                    'key'     => 'season_to',
                    'value'   => $today,
                    'type'    => 'DATE',
                    'compare' => '>='
                ]
            ],
            [
                'relation' => 'AND',
                [
                    'key'     => 'season_from',
                    'value'   => $today,
                    'type'    => 'DATE',
                    'compare' => '>='
                ]
            ]
        ]
    );
    $intervalsQuery = new \WP_Query;
    $intervals = $intervalsQuery->query($seasonsIntervalsParams);

    $intervals = array_map(function ($interval) {
        return [
            'season_from' => get_post_meta($interval->ID, 'season_from', 1),
            'season_to' => get_post_meta($interval->ID, 'season_to', 1),
            'season_id' => get_post_meta($interval->ID, 'season_id', 1)
        ];
    }, $intervals);

    $season_from_column = array_column($intervals, 'season_from');
    array_multisort($season_from_column, SORT_ASC, $intervals);

    $result = [];
    foreach ($intervals as $interval) {
        if (!in_array($interval['season_id'], $result)) {
            $result[] = $interval['season_id'];
        }
    }

    return $result;
}

include('calendar-season-shortcodes.php');
include('discounts-shortcodes.php');
// $hello = new PaymentService();
// $hello_response = $hello->initRegisterDo();

// Log::info('hello_response', $hello_response);
