<?php
    if (!defined('ABSPATH')) {
        exit;
    }

    $source = $_GET['source'];
    $ID;
    $formData;

    if(empty( $source)){
        exit;
    }

    $args = array(
        'post_type'  => 'sbc_orders',
        'meta_query' => array(
            array(
                'key'     => 'sbc_order_prepaid_source',
                'value'   =>  $source,
                'compare' => '=',
            ),
        ),
    );

    $query = new WP_Query( $args );
    while ( $query->have_posts() ) {
        $query->the_post();
        $ID = get_the_ID();
        break;
    }

    if(isset($ID)){
        $formData = get_post_meta($ID, 'sbc_order_prepaid_value', 1);
        $isReserved = get_post_meta($ID, 'sbc_order_select', 1) == 'reserved';
        if(!$isReserved){
            echo 'Этот заказ уже оплачен';
            exit;
        }
    }

    if(empty($formData)){
        exit;
    }

    $paymentOrg = get_webpay_sandbox();

?>
<body>
    <script>
        const params = <?=$formData?>;
        generateAndSubmitForm("<?=$paymentOrg;?>", params.values, params.names);

        function generateAndSubmitForm(action, paramsWithValue, paramsWithNames, method = 'POST') {
            const form = document.createElement("form");
            form.action = action;
            form.method = method;

            paramsWithValue.wsb_cancel_return_url = `https://krasnagorka.by/booking-form?clear=${paramsWithValue.wsb_order_num}`;

            for (const key in paramsWithValue) {
                const element = document.createElement("input");
                element.type = "hidden";
                element.name = key;
                element.value = paramsWithValue[key];
                form.appendChild(element);
            }

            for (const key of paramsWithNames) {
                const element = document.createElement("input");
                element.type = "hidden";
                element.name = key;
                form.appendChild(element);
            }

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>