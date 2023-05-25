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
    private string $PROD_LINK = 'https://ecom.alfabank.by/payment/rest/';

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

    public function getLinkForRegisterDo(Order $order) {
        $amount = $order->price * 100;
        return "{$this->base_link}register.do?password={$this->password}&userName={$this->username}&amount={$amount}&language=ru&orderNumber={$order->id}&returnUrl={$this->return_url}&pageView={$this->device_type}";
    }

    // formUrl
    // orderId

    // errorCode

    public function initRegisterDo(Order $order)
        {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_HTTPHEADER => [],
                CURLOPT_VERBOSE => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_URL => $this->getLinkForRegisterDo($order),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => false,
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }

}


// use LsFactory\PaymentService as PaymentService;
