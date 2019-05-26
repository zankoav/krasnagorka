<?php
/*
Plugin Name: CMB2 Field Type: Post Search Ajax
Plugin URI: https://github.com/alexis-magina/cmb2-field-post-search-ajax
GitHub Plugin URI: https://github.com/alexis-magina/cmb2-field-post-search-ajax
Description: CMB2 field type to attach posts to each others.
Version: 1.0.0
Author: Magina
Author URI: http://magina.fr/
License: GPLv2+
*/

/**
 * Class MAG_CMB2_Field_Post_Search_Ajax
 */
class MAG_CMB2_Field_Post_Search_Ajax {

	/**
	 * Current version number
	 */
	const VERSION = '1.0.0';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	public function __construct() {
		add_action( 'cmb2_render_post_search_ajax', array( $this, 'render' ), 10, 5 );
		add_action( 'cmb2_sanitize_post_search_ajax', array( $this, 'sanitize' ), 10, 4 );
		add_action( 'wp_ajax_cmb_post_search_ajax_get_results', array( $this, 'cmb_post_search_ajax_get_results' ) );
	}

	/**
	 * Render field
	 */
	public function render( $field, $value, $object_id, $object_type, $field_type ) {	
		$this->setup_admin_scripts();
		$field_name = $field->_name();
		
		if($field->args( 'limit' ) > 1){
			echo '<ul class="cmb-post-search-ajax-results" id="' . $field_name . '_results">';
			if( isset($value) && !empty($value) ){
				if( !is_array($value) ){ $value = array($value); }
				foreach($value as $val){
					$handle = ($field->args( 'sortable' )) ? '<span class="hndl"></span>' : '';	
					echo '<li>'.$handle.'<input type="hidden" name="'.$field_name.'_results[]" value="'.$val.'"><a href="'.get_edit_post_link($val).'" target="_blank" class="edit-link">'.get_the_title($val).'</a><a class="remover"><span class="dashicons dashicons-no"></span><span class="dashicons dashicons-dismiss"></span></a></li>';
				}
			}
			echo '</ul>';			
			$field_value = '';
		}
		else{
			$field_value = ($value ? get_the_title($value) : '');
			echo $field_type->textarea( array(
				'class'	=> 'hidden',
				'name' 	=> $field_name . '_results',
				'desc'	=> $value[0].$value[1].$value[2].$value[3]
			) );
		}
		
		echo $field_type->input( array( 
			'type' 			=> 'text',
			'name' 			=> $field_name,
			'id'			=> $field_name,
			'class'			=> 'cmb-post-search-ajax',
			'value' 		=> $field_value,
			'desc'			=> false,
			'data-limit'	=> $field->args( 'limit' ) ? $field->args( 'limit' ) : '1',
			'data-sortable'	=> $field->args( 'sortable' ) ? $field->args( 'sortable' ) : '0',
			'data-queryargs'=> $field->args( 'query_args' ) ? htmlspecialchars( json_encode( $field->args( 'query_args' ) ), ENT_QUOTES, 'UTF-8' ) : ''
		) );
		
		echo '<img src="'.admin_url( 'images/spinner.gif' ).'" class="cmb-post-search-ajax-spinner" />';		
		
		$field_type->_desc( true, true );
		
	}

	/**
	 * Optionally save the latitude/longitude values into two custom fields
	 */
	public function sanitize( $override_value, $value, $object_id, $field_args ) {
		$fid = $field_args['id'];
		if($field_args['render_row_cb'][0]->data_to_save[$fid.'_results']){
			$value = $field_args['render_row_cb'][0]->data_to_save[$fid.'_results'];
		}
		else{
			$value = false;
		}
		return $value;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function setup_admin_scripts() {
		
		wp_register_script( 'jquery-autocomplete', CALENDAR_VENDOR_URI .  'cmb2-field-post-search-ajax/js/jquery.autocomplete.min.js' , array( 'jquery' ), self::VERSION );
		wp_register_script( 'mag-post-search-ajax', CALENDAR_VENDOR_URI . 'cmb2-field-post-search-ajax/js/mag-post-search-ajax.js', array( 'jquery', 'jquery-autocomplete', 'jquery-ui-sortable' ), self::VERSION );
		wp_localize_script( 'mag-post-search-ajax', 'psa', array(
			'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
			'nonce'		=> wp_create_nonce( 'mag_cmb_post_search_ajax_get_results' )
		) ); 
		wp_enqueue_script( 'mag-post-search-ajax' );
		wp_enqueue_style( 'mag-post-search-ajax', CALENDAR_VENDOR_URI . 'cmb2-field-post-search-ajax/css/mag-post-search-ajax.css', array(), self::VERSION );
		
	}
	
	/**
	 * Ajax request : get results
	 */
	public function cmb_post_search_ajax_get_results() {
		$nonce = $_POST['psacheck'];
		if ( ! wp_verify_nonce( $nonce, 'mag_cmb_post_search_ajax_get_results' ) ) {
			die( json_encode( array( 'error' => __( 'Error : Unauthorized action' ) ) ) );
		}
		else {
			$args 		= json_decode(stripslashes(htmlspecialchars_decode($_POST['query_args'])), true);
			$args['s'] 	= $_POST['query'];
			$results 	= new WP_Query( $args );
			$datas 		= array();
			if ( $results->have_posts() ) :
				while ( $results->have_posts() ) : $results->the_post();
					$datas[] = array(
						'value' => get_the_title(),
						'data'	=> get_the_ID(),
						'guid'	=> get_edit_post_link(),
						'phone'	=> get_post_meta(get_the_ID(), 'sbc_client_phone', true),
						'email'	=> get_post_meta(get_the_ID(), 'sbc_client_email', true),
						'desc'	=> get_post_meta(get_the_ID(), 'sbc_client_desc', true),
					);
				endwhile;
			endif;
			wp_reset_postdata();
			die( json_encode( $datas ) );			
		}
	}
	
}
$mag_cmb2_field_post_search_ajax = new MAG_CMB2_Field_Post_Search_Ajax();
