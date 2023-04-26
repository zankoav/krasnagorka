<?php

namespace LsFactory;

use LsFactory\Order;
use Ls\Wp\Log as Log;

class PaymentService {

    public ?string $return_url;
    public ?string $username;
    public ?string $password;
    public ?string $base_link;
    public ?string $device_type;
    public bool $is_enable;
    public bool $is_production;

    private string $SANDBOX_LINK = 'https://abby.rbsuat.com/payment/rest/';
    private string $PROD_LINK = 'https://abby.rbsuat.com/payment/rest/';

    public function __construct(){
        $settings = get_option('mastak_theme_options');
        $this->is_enable = $settings['alpha_bank_settings_enabled'] == 'on';
        if($this->is_enable){
            $this->is_production = $settings['alpha_bank_settings_production_enabled'] == 'on';
            $this->username = $this->is_production ? $settings['alpha_bank_settings_username_prod'] : $settings['alpha_bank_settings_username_sandbox'];
            $this->password = $this->is_production ? $settings['alpha_bank_settings_password_prod'] : $settings['alpha_bank_settings_password_sandbox'];
            $this->base_link = $this->is_production ? $this->PROD_LINK : $this->SANDBOX_LINK;
            $this->return_url = $settings['alpha_bank_settings_return_url'];
            $this->device_type = wp_is_mobile() ? 'MOBILE' : 'DESKTOP';
        }
    }

    public function getLinkForRegisterDo1() {
        $amount = 99;
        $orderNumber = 1999;
        return "{$this->base_link}register.do?password={$this->password}&userName={$this->username}&amount={$amount}&language=ru&orderNumber={$orderNumber}&returnUrl={$this->return_url}&pageView={$this->device_type}";
    }

    // public function getLinkForRegisterDo() {
    //     return ;
    // }

    // public function getInitRegisterDo() {
    //     return file_get_contents($this->getLinkForRegisterDo());
    // }

    public function initRegisterDo($headers = array())
        {
            $amount = 99;
            $orderNumber = 4000;

            $data = [
                'password' => $this->password,
                'userName' =>$this->username,
                'amount' => $amount,
                'language' => 'ru',
                'orderNumber' => $orderNumber,
                'returnUrl' => $this->return_url,
                'pageView' => $this->device_type
            ];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_VERBOSE => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => $this->getLinkForRegisterDo1(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => false,
                // CURLOPT_POSTFIELDS => $data,
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response);
        }







    // public function initRequest(Order $order);
    

    // public function setVariable($name, $var);

    
    // function url(){
    //     return  'https://abby.rbsuat.com/payment/rest/register.do?password=5HiCN5ZMex5{f}&userName=krasnagorka.by_4F83135F4968F-api&amount=101&language=ru&orderNumber=123&returnUrl=https%3A%2F%2Fkrasnagorka.by%2Ftest&pageView=DESKTOP';
    // }

    // public function register_do($request){
    //     $calendarId = $request['calendarId'];
    //     $dateStart = date("Y-m-d", strtotime($request['dateStart']));
    //     $dateEnd =  date("Y-m-d", strtotime($request['dateEnd']));
    //     $toDay = date("Y-m-d");

    //     if (empty($calendarId) or empty($dateStart) or empty($dateEnd)) {
    //         return new WP_REST_Response(['error' => 'Invalid data'], 400); 
    //     }

    //     $result = [
    //         'available' => true
    //     ];

    //     if($toDay > $dateStart){
    //         $result['available'] = false;
    //         $result['message'] = 'Упс! Устаревшая бронь :(';
    //         return new WP_REST_Response($result, 200); 
    //     }

    //     $ordersQuery = new WP_Query;
    //     $orders = $ordersQuery->query(array(
    //         'post_type' => 'sbc_orders',
    //         'posts_per_page' => -1,
    //         'tax_query' => [
    //             [
    //                 'taxonomy' => 'sbc_calendars',
    //                 'terms' => [$calendarId]
    //             ]
    //         ],
    //         'meta_query' => array(
    //             array(
    //                 'key'     => 'sbc_order_end',
    //                 'value'   => $dateStart,
    //                 'compare' => '>=',
    //             )
    //         )
    //     ));

    //     $parseResult = [];

    //     foreach ($orders  as $item) {
    //         $orderId = $item->ID;
    //         $start = get_post_meta($orderId, 'sbc_order_start', true);
    //         $startTime = strtotime($start);
    //         $start = date('Y-m-d', $startTime);
    //         $end = get_post_meta($orderId, 'sbc_order_end', true);
    //         $endTime = strtotime($end);
    //         $end = date('Y-m-d', $endTime);
    //         $parseResult[] = [$start, $end, $orderId];
    //     }
        
    //     foreach ($parseResult as $r) {
    //         $from = $r[0];
    //         $to = $r[1];
    //         $orId = $r[2];

    //         if ($dateStart >= $from and $dateStart < $to) {
    //             $result['available'] = false;
    //         }

    //         if ($dateEnd > $from and $dateEnd <= $to) {
    //             $result['available'] = false;
    //         }

    //         if ($dateStart < $from and $dateEnd > $to) {
    //             $result['available'] = false;
    //         }
    //     }   

    //     if(!$result['available']){
    //         $result['message'] = 'Упс! Бронь уже занята :(';
    //     }
        
    //     return new WP_REST_Response($result, 200); 
    // }

    // /**
    //  * addres wordpress/wp-json/krasnagorka/v1/ls/event-tab/?tabId=5  
    // */ 
    // public function event_tab($request){
    //     $tabId = absint($request['tabId']);
    //     $tab = new Type_10($tabId);
    //     return new WP_REST_Response($tab->getData(), 200); 
    // }

}


// use LsFactory\PaymentService as PaymentService;
