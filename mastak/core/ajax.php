<?php
    function calendar_action() {
        if (isset($_POST['id'], $_POST['slug'])) {
            $id   = $_POST['id'];
            $slug = $_POST['slug'];
            echo do_shortcode("[sbc_calendar id=\"$id\" slug=\"$slug\"]");
        }
        wp_die();
    }

    add_action('wp_ajax_calendar_action', 'calendar_action');
    add_action('wp_ajax_nopriv_calendar_action', 'calendar_action');

    function comments_action() {
        if (isset($_POST['range'])) {

            $range = $_POST['range'];

            $comments = get_comments(array(
                'post_id'      => 9105,
                'status'       => 'approve',
                'number'       => 20,
                'offset'       => $range,
                'hierarchical' => 'threaded'
            ));

            $result = [];
            /**
             * @var WP_Comment $comment
             */
            foreach ($comments as $comment) {
                $result[] = [
                    'id' => $comment->comment_ID,
                    'rating' => get_comment_meta($comment->comment_ID, 'rating_reviews', 1),
                    'comment_content' => $comment->comment_content,
                    'comment_autor' => $comment->comment_author,
                    'comment_date' => date_format($comment->comment_date, 'd.m.Y'),
                    'children' => $comment->get_children()
                ];
            }

            echo json_encode(['comments' => $result, 'status' => 1]);
        }
        wp_die();
    }

    add_action('wp_ajax_comments_action', 'comments_action');
    add_action('wp_ajax_nopriv_comments_action', 'comments_action');

