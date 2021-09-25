<?php

use Cmb2Grid\Grid\Cmb2Grid;

function payment_metabox() {

    $sbc_client = new_cmb2_box(array(
        'id'           => 'payment_data',
        'title'        => esc_html__('Payment Info', 'krasnagorka'),
        'object_types' => array('sbc_orders'),
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true,
    ));

    $sbc_client->add_field(array(
        'name' => 'Способ оплаты',
        'id'   => 'sbc_order_payment_method',
        'type' => 'select',
        'show_option_none' => true,
        'options' => array(
            'card'  => __('Картой', 'krasnagorka'),
            'card_layter' => __('Картой позже', 'krasnagorka'),
            'office' => __('В оффисе', 'krasnagorka')
        )
    ));

    $sbc_client->add_field(array(
        'name' => 'Оплата',
        'id'   => 'sbc_order_prepaid_percantage',
        'type'         => 'text_small',
        'before_field' => '%'
    ));

    $sbc_client->add_field(array(
        'name' => 'Ссылка на оплату',
        'desc' => 'Данная ссылка отправляется клиенту в случае оплаты по карте позже',
        'id'   => 'sbc_order_prepaid_link',
        'type' => 'text_url'
    ));

    $sbc_client->add_field(array(
        'id'   => 'sbc_order_prepaid_value',
        'type' => 'hidden'
    ));
}

add_action('cmb2_admin_init', 'payment_metabox');