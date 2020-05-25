<?php


if (!defined('ABSPATH')) {
    exit;
}
require __DIR__ . '/backend/Logger.php';
require __DIR__ . '/backend/Assets.php';
require __DIR__ . '/backend/Model.php';

$assets = new Assets();
$model  = new Model();

add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/admin-style.css', false, '1.0.0');
}


// for delete

if (!isset($content_width)) {
    $content_width = 1200; /* pixels */
}
require __DIR__ . '/inc/calendar/init.php';
require __DIR__ . '/mastak/init.php';
require __DIR__ . '/rest/Booking_Form_Controller.php';

add_action('rest_api_init', function () {
    $booking_form_controller = new Booking_Form_Controller();
    $booking_form_controller->register_routes();
});

function getCalendarId($calendarShortCode)
{
    $arr = explode("\"", $calendarShortCode);
    return $arr[1];
}

    //    add_filter('wpseo_schema_graph_pieces', function ($pieces, $context) {
    //
    //        if (get_the_ID() == 10188) {
    //            var_dump($pieces[0]);
    //            $pieces[0]['aggregateRating'] = [
    //                '@type'       => 'AggregateRating',
    //                'ratingValue' => 4.5,
    //                'ratingCount' => 120
    //            ];
    //            unset($pieces[0]);
    //            unset($pieces[2]);
    //            unset($pieces[3]);
    //            unset($pieces[4]);
    //            unset($pieces[5]);
    //        }
    //
    //        return $pieces;
    //    }, 20, 2);


    function cmb2_after_form_do_js_validation( $post_id, $cmb ) {
        static $added = false;
    
        // Only add this to the page once (not for every metabox)
        if ( $added ) {
            return;
        }
    
        $added = true;
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
    
            $form = $( document.getElementById( 'post' ) );
            $htmlbody = $( 'html, body' );
            $toValidate = $( '[data-validation]' );
    
            if ( ! $toValidate.length ) {
                return;
            }
    
            function checkValidation( evt ) {
                var labels = [];
                var $first_error_row = null;
                var $row = null;
    
                function add_required( $row ) {
                    $row.css({ 'background-color': 'rgb(255, 170, 170)' });
                    $first_error_row = $first_error_row ? $first_error_row : $row;
                    labels.push( $row.find( '.cmb-th label' ).text() );
                }
    
                function remove_required( $row ) {
                    $row.css({ background: '' });
                }
    
                $toValidate.each( function() {
                    var $this = $(this);
                    var val = $this.val();
                    $row = $this.parents( '.cmb-row' );
    
                    if ( $this.is( '[type="button"]' ) || $this.is( '.cmb2-upload-file-id' ) ) {
                        return true;
                    }
    
                    if ( 'required' === $this.data( 'validation' ) ) {
                        if ( $row.is( '.cmb-type-file-list' ) ) {
    
                            var has_LIs = $row.find( 'ul.cmb-attach-list li' ).length > 0;
    
                            if ( ! has_LIs ) {
                                add_required( $row );
                            } else {
                                remove_required( $row );
                            }
    
                        } else {
                            if ( ! val ) {
                                add_required( $row );
                            } else {
                                remove_required( $row );
                            }
                        }
                    }
    
                });
    
                if ( $first_error_row ) {
                    evt.preventDefault();
                    alert( '<?php _e( 'The following fields are required and highlighted below:', 'cmb2' ); ?> ' + labels.join( ', ' ) );
                    $htmlbody.animate({
                        scrollTop: ( $first_error_row.offset().top - 200 )
                    }, 1000);
                } else {
                    // Feel free to comment this out or remove
                    alert( 'submission is good!' );
                }
    
            }
    
            $form.on( 'submit', checkValidation );
        });
        </script>
        <?php
    }
    
    add_action( 'cmb2_after_form', 'cmb2_after_form_do_js_validation', 10, 2 );