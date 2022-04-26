<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }

function order_amocrm_metabox() {

    $sbc_client = new_cmb2_box(array(
        'id'           => 'order_data',
        'title'        => esc_html__('AmoCRM Info', 'krasnagorka'),
        'object_types' => array('sbc_orders'), // Post type
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true, // Show field names on the left
    ));

    $sbc_client->add_field(array(
        'name' => 'Паспорт клиента',
        'id'   => 'sbc_order_passport',
        'type' => 'text',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));

    $sbc_client->add_field(array(
        'name' => 'Количество человек',
        'id'   => 'sbc_order_count_people',
        'type' => 'text_small',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));

    $sbc_client->add_field(array(
        'name' => 'Lead ID',
        'id'   => 'sbc_lead_id',
        'type' => 'text_small',
        'attributes' => array(
            'readonly' => 'readonly'
        ),
        'column' => array(
            'name'     => 'Lead Id',
        )
    ));

    $sbc_client->add_field(array(
        'name' => 'Webpay transaction ID',
        'id'   => 'sbc_webpay_transaction_id',
        'type' => 'text_small',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));

    $sbc_client->add_field(array(
        'name' => 'Task ID',
        'id'   => 'sbc_task_id',
        'type' => 'text_small',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));

}

add_action('cmb2_admin_init', 'order_amocrm_metabox');