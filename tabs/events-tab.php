<?php

function event_tab_order_settings($box_id, $cmb)
{
    $post_id = $_GET['post'];
    if (empty($post_id) || $box_id != 'mastak_event_tab_type_10') {
        return;
    }

    $postItems = get_post_meta($post_id, 'mastak_event_tab_type_10_items', 1);
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
    <script type="text/javascript">
        var orderedIds = JSON.parse('<?= $ids_json; ?>');
    </script>

<?php
}

add_action('cmb2_after_form', 'event_tab_order_settings', 10, 3);