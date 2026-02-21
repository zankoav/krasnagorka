<?php
	add_action( 'add_meta_boxes', 'remove_sbc_orders_wp_seo_meta_box', 100 );
	add_filter( 'manage_edit-sbc_orders_columns', 'yoast_seo_remove_columns' );

	function remove_sbc_orders_wp_seo_meta_box() {
		remove_meta_box( 'wpseo_meta', 'sbc_orders', 'normal' );
	}

	add_action( 'pre_get_posts', 'sbc_pre_get_posts' );
	function sbc_pre_get_posts( $query ) {

		//Only alter query if custom variable is set.
		$month_str = $query->get( 'custom_month' );
		if ( ! empty( $month_str ) ) {

			//Be careful not override any existing meta queries.
			$meta_query = $query->get( 'meta_query' );
			if ( empty( $meta_query ) ) {
				$meta_query = array();
			}

			//Convert 2012/05 into a datetime object get the first and last days of that month in yyyy/mm/dd format
			$month = new DateTime( $month_str . '/01' );
			//Get posts with date between the first and last of given month
			$meta_query[] = array(
				'key'     => 'sbc_order_start',
				'value'   => array( $month->format( 'Y-m-d' ), $month->format( 'Y-m-t' ) ),
				'compare' => 'BETWEEN',
			);
			$query->set( 'meta_query', $meta_query );

		}

		if ( isset( $_GET['status'] ) && $_GET['status'] != '' ) {

			$meta_query = $query->get( 'meta_query' );
			if ( empty( $meta_query ) ) {
				$meta_query = array();
			}

			$meta_query[] = array(
				'key'   => 'sbc_order_select',
				'value' => $_GET['status']
			);
			$query->set( 'meta_query', $meta_query );
		}

		if ( isset( $_GET['actual'] ) && $_GET['actual'] != '' ) {


			$meta_query = $query->get( 'meta_query' );
			if ( empty( $meta_query ) ) {
				$meta_query = array();
			}

			$isArchive = $_GET['actual'] === 'archive';

			$meta_query[] = array(
				'key'     => 'sbc_order_end',
				'value'   => date( "Y-m-d", strtotime( "-1 week" ) ),
				'compare' => $isArchive ? '<' : '>='
			);
			$query->set( 'meta_query', $meta_query );
		}
	}

	add_filter( 'query_vars', 'sbc_register_query_vars' );
	function sbc_register_query_vars( $qvars ) {
		$qvars[] = 'custom_month';
		return $qvars;
	}

	add_action( 'restrict_manage_posts', 'rudr_posts_taxonomy_filter' );

	function rudr_posts_taxonomy_filter() {
		global $typenow; // this variable stores the current custom post type
		if ( $typenow == 'sbc_orders' ) { // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
			$taxonomy_names = array( 'sbc_calendars' );
			foreach ( $taxonomy_names as $single_taxonomy ) {
				$current_taxonomy = isset( $_GET[ $single_taxonomy ] ) ? $_GET[ $single_taxonomy ] : '';
				$taxonomy_object  = get_taxonomy( $single_taxonomy );
				$taxonomy_name    = strtolower( $taxonomy_object->labels->name );
				$taxonomy_terms   = get_terms( $single_taxonomy );
				if ( count( $taxonomy_terms ) > 0 ) {
					echo "<select name='$single_taxonomy' id='$single_taxonomy' class='postform'>";
					echo "<option value=''>Все $taxonomy_name</option>";
					foreach ( $taxonomy_terms as $single_term ) {
						echo '<option value=' . $single_term->slug, $current_taxonomy == $single_term->slug ? ' selected="selected"' : '', '>' . $single_term->name . ' (' . $single_term->count . ')</option>';
					}
					echo "</select>";
				}
			}
		}
	}

	add_action( 'restrict_manage_posts', 'sbc_restrict_posts_by_metavalue' );
	function sbc_restrict_posts_by_metavalue() {
		global $typenow;
		$months = sbc_get_months();
		if ( $typenow == 'sbc_orders' ) {
			$selected = get_query_var( 'custom_month' );
			$output   = "<select style='width:150px' id='custom_month' name='custom_month' class='postform'>\n";
			$output   .= '<option ' . selected( $selected, 0, false ) . ' value="">' . __( 'Месяц заезда', 'sbc_plugin' ) . '</option>';
			if ( isset( $months ) && ! empty( $months ) ) {
				foreach ( $months as $month ):
					if ( ! empty( $month->year ) ) {
						$value      = esc_attr( $month->year . '/' . $month->month );
						$month_dt   = new Datetime( $month->year . '-' . $month->month . '-01' );
						$month_frmt = $month_dt->format( 'U' );
						$c_date     = date_i18n( 'F Y', $month_frmt );
						$output     .= "<option value='{$value}' " . selected( $selected, $value, false ) . '>' . $c_date . '</option>';
					}
				endforeach;
			}

			$output .= "</select>\n";
			echo $output;
		}
	}

	add_action( 'restrict_manage_posts', 'filter_view_post_status' );

	function filter_view_post_status() {
		$values = array(
			'Зарезервирован' => 'reserved',
			'Предоплачен'    => 'prepaid',
			'Оплачен'        => 'booked'
		);
		?>
        <select name="status">
            <option value=""><?php _e( 'Статус заказа', 'sbc' ); ?></option>
			<?php
				$current_v = isset( $_GET['status'] ) ? $_GET['status'] : '';
				foreach ( $values as $label => $value ) {
					printf
					(
						'<option value="%s"%s>%s</option>',
						$value,
						$value == $current_v ? ' selected="selected"' : '',
						$label
					);
				}
			?>
        </select>
		<?php

		$values = array(
			'Актуальные' => 'actual',
			'В архиве'   => 'archive'
		);
		?>
        <select name="actual">
            <option value=""><?php _e( 'Заказы (актуальность)', 'sbc' ); ?></option>
			<?php
				$current_v = isset( $_GET['actual'] ) ? $_GET['actual'] : '';
				foreach ( $values as $label => $value ) {
					printf
					(
						'<option value="%s"%s>%s</option>',
						$value,
						$value == $current_v ? ' selected="selected"' : '',
						$label
					);
				}
			?>
        </select>
		<?php

	}

	/**
	 * END FILTERS
	 */

	/**
	 * ORDER BLOCK
	 */

	add_filter( 'manage_edit-sbc_orders_sortable_columns', 'sortable_sbc_order_start' );

	function sortable_sbc_order_start( $columns ) {

		$columns['sbc_order_start']  = 'sbc_order_start';
		$columns['sbc_order_end']    = 'sbc_order_end';
		$columns['sbc_order_client'] = 'sbc_order_client';
		$columns['sbc_order_price']  = 'sbc_order_price';
		$columns['sbc_lead_id']  = 'sbc_lead_id';

		return $columns;
	}

	add_action( 'pre_get_posts', 'orderRules', 1 );

	function orderRules( $query ) {

		/**
		 * We only want our code to run in the main WP query
		 * AND if an orderby query variable is designated.
		 */
		if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {

			switch ( $orderby ) {
				case 'sbc_order_start':
					$query->set( 'meta_key', 'sbc_order_start' );
					$query->set( 'orderby', 'meta_value' );
					break;
				case 'sbc_order_end':
					$query->set( 'meta_key', 'sbc_order_end' );
					$query->set( 'orderby', 'meta_value' );
					break;
				case 'sbc_order_client':
					$query->set( 'meta_key', 'sbc_order_client' );
					$query->set( 'orderby', 'meta_value_num' );
					break;
				case 'sbc_order_price':
					$query->set( 'meta_key', 'sbc_order_price' );
					$query->set( 'orderby', 'meta_value_num' );
					break;
				case 'sbc_lead_id':
					$query->set( 'meta_key', 'sbc_lead_id' );
					$query->set( 'orderby', 'meta_value_num' );
					break;
				default:
					break;
			}

		}
	}
?>