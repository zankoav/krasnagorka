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
        'type' => 'text_small'
    ));

    $sbc_client->add_field(array(
        'name' => 'Task ID',
        'id'   => 'sbc_task_id',
        'type' => 'text_small',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));
    
    $sbc_client->add_field(array(
        'name' => 'Создать задачу в АМО',
        'description' => 'Напомнить клиенту оплатить бронь, так как осталось мало времени (около 15 часов) до снятия брони',
        'id'   => 'sbc_remind_task',
        'type' => 'checkbox',
        'attributes' => array(
            'readonly' => 'readonly'
        )
    ));

}

add_action('cmb2_admin_init', 'order_amocrm_metabox');