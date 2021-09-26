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
    }

    if(empty($formData)){
        exit;
    }

?>
<body>
    <script>
        const params = <?=$formData?>;
        const paymentOrg = false ? 'https://securesandbox.webpay.by' : 'https://payment.webpay.by'
        generateAndSubmitForm(paymentOrg, params.values, params.names);

        function generateAndSubmitForm(action, paramsWithValue, paramsWithNames, method = 'POST') {
            const form = document.createElement("form");
            form.action = action;
            form.method = method;

            paramsWithValue.wsb_cancel_return_url = `${location.href}&clear=${paramsWithValue.wsb_order_num}`;

            // eslint-disable-next-line guard-for-in
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