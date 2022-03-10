<?php

use Ls\Wp\Log as Log;

if (!defined('ABSPATH')) { exit; }

// START

require __DIR__ . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

if(class_exists('Html2Pdf')){
    Log::info('OK','OK');
}else{
    Log::info('NO','NO');
}

require __DIR__ . '/L-S/utils/index.php';
require __DIR__ . '/L-S/setup.php';
require __DIR__ . '/L-S/cmb2/index.php';
require __DIR__ . '/L-S/widgets/index.php';
require __DIR__ . '/L-S/mail/LS_Mailer.php';

require __DIR__ . '/backend/Logger.php';
require __DIR__ . '/backend/Assets.php';
require __DIR__ . '/backend/Model.php';

$assets = new Assets();
$model  = new Model();

require __DIR__ . '/token_actions.php';
require __DIR__ . '/inc/calendar/init.php';
require __DIR__ . '/mastak/init.php';
require __DIR__ . '/rest/rest.php';

require __DIR__ . '/LS/backend/rest/rest.php';

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
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0');
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

function change_ordered_color($box_id, $cmb)
{
    $post_id = $_GET['post'];
    if (empty($post_id) || $box_id != 'mastak_event_tab_type_8') {
        return;
    }

    $postItems = get_post_meta($post_id, 'mastak_event_tab_type_8_items', 1);
    $ids = [];
    $index = 0;
    foreach ($postItems as $postItem) {
        $from = $postItem['from'];
        $to = $postItem['to'];
        $calendarId = $postItem['calendar'];
        if ($status = getOrderStatus($calendarId, $from, $to)) {
            $ids[$index] = ['calendar' => $calendarId, 'status' => $status];
        } else if (date("Ymd", strtotime($from)) <  date("Ymd")) {
            $ids[$index] = ['calendar' => $calendarId, 'status' => 'expired'];
        }
        $index++;
    }

    $ids_json = json_encode($ids);
?>
    <style>
        .bgc-reserved {
            background-color: #c7dff1 !important;
        }

        .bgc-prepaid {
            background-color: #ffecb5 !important;
        }

        .bgc-booked {
            background-color: #fdb7ce !important;
        }

        .bgc-expired {
            background-color: #72777c !important;
        }
    </style>
    <script type="text/javascript">
        var orderedIds = JSON.parse('<?= $ids_json; ?>');
        console.log('orderedIds', orderedIds);
        jQuery(document).ready(function($) {
            $('#cmb2-metabox-mastak_event_tab_type_8').find('.postbox').each(function(index, item) {
                const state = orderedIds[index];
                const id = `#mastak_event_tab_type_8_items_${index}_calendar`;
                const $calendar = $(this).find(id);
                if (state && $calendar[0] && $calendar[0].value == state.calendar) {
                    $(this).addClass(`bgc-${state.status}`);
                    $(this).find('.cmb-group-title').addClass(`bgc-${state.status}`);
                }
            });
        });
    </script>
<?php
}

add_action('cmb2_after_form', 'change_ordered_color', 10, 2);


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
    return $schedules;
}

add_action('wp', 'kg_clear_order');
function kg_clear_order()
{
    $time = time();
    if (!wp_next_scheduled('kg_clear_order_five_min_event')) {
        wp_schedule_event($time, 'five_min', 'kg_clear_order_five_min_event');
    }

    if (!wp_next_scheduled('kg_clear_order_1_day_min_event')) {
        wp_schedule_event($time, 'one_day', 'kg_clear_order_1_day_min_event');
    }
}

add_action('kg_clear_order_1_day_min_event', 'kg_clear_orders_2');
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

//END */