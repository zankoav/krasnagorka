<?php
    use Ls\Wp\Log as Log;


	add_action( 'load-edit.php', 'custom_load_edit', 1 );

	function custom_load_edit() {
		global $typenow;

		switch ( $typenow ) {
			case 'sbc_orders' :
				require_once CALENDAR_ROOT . 'sbc-orders-page.php';
				break;
			default:
				break;
		}

	}

	/**
	 * Wordpress: Filter admin columns and remove YOAST SEO columns
	 */
	function yoast_seo_remove_columns( $columns ) {
		/* remove the Yoast SEO columns */
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );
		unset( $columns['wpseo-score-readability'] );
		unset( $columns['wpseo-links'] );

		return $columns;
	}

	function calendar_scripts() {
		wp_enqueue_style( 'fullcalendar_public_style', CALENDAR_ROOT_URI . 'css/public_style.css' );

		wp_enqueue_script( 'moment',CALENDAR_ROOT_URI . 'js/moment.js' , array( 'jquery' ), false, true );
		wp_enqueue_script( 'fullcalendar',CALENDAR_ROOT_URI . 'js/fullcalendar.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'fullcalendar_locale',CALENDAR_ROOT_URI . 'js/ru.js', array( 'jquery', 'moment' ), false, true );
        wp_enqueue_script( 'public_calendar',CALENDAR_ROOT_URI . 'js/public.js', array( 'jquery' ), false, true );
	}

	if(!is_admin()){
        add_action( "wp_enqueue_scripts", "calendar_scripts" );
    }

	function my_enqueue() {
		wp_enqueue_style( 'fullcalendar_admin_style', CALENDAR_ROOT_URI . 'css/admin_style.css' );

		wp_enqueue_script( 'moment', CALENDAR_ROOT_URI . 'js/moment.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'fullcalendar',CALENDAR_ROOT_URI . 'js/fullcalendar.min.js',  array( 'jquery' ), false, true );
        wp_enqueue_script( 'fullcalendar_locale',CALENDAR_ROOT_URI . 'js/ru.js', array( 'jquery', 'moment' ), false, true );
		wp_enqueue_script( 'admin_calendar',CALENDAR_ROOT_URI . 'js/admin.js',  array( 'jquery' ), false, true );
	}

    if(is_admin()){
        add_action( 'admin_enqueue_scripts', 'my_enqueue' );
    }

	add_action( 'rest_api_init', function () {
		register_rest_route( 'calendars', '/(?P<slug>[a-z0-9\-]+)', [
			'methods'  => 'GET',
			'callback' => 'app_get_post',
		] );
	} );

	function app_get_post( $data ) {
		$rest  = [];
		$args  = array(
			'post_type'      => 'sbc_orders',
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => - 1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'sbc_calendars',
					'field'    => 'slug',
					'terms'    => $data['slug'],
				)
			),
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$start  = get_post_meta( get_the_ID(), 'sbc_order_start', true );
			$end    = get_post_meta( get_the_ID(), 'sbc_order_end', true );
			$status = get_post_meta( get_the_ID(), 'sbc_order_select', true );

			switch ( $status ) {
				case 'booked':
					$color = '#e91e63';
					break;
				case 'reserved':
					$color = '#65b2ed';
					break;
				case 'prepaid':
					$color = '#ffc107';
					break;
			}

			$date_s = new DateTime( $start );
			$start  = $date_s->format( "Y-m-d" );

			$date_e = new DateTime( $end );
			$date_e->add( new DateInterval( 'P1D' ) );
			$end = $date_e->format( "Y-m-d" );

			$rest[] = array(
				'id'     => get_the_ID(),
				'title'  => get_the_title(),
				'start'  => $start,
				'end'    => $end,
				'allDay' => true,
				'color'  => $color
			);
		endwhile;
			wp_reset_postdata();
		endif;

		return $rest;
	}

    add_action( 'rest_api_init', function () {
		register_rest_route( 'happy/v1', '/events/', [
			'methods'  => 'GET',
			'callback' => 'app_get_happy_events',
		] );
	} );

    function app_get_happy_events() {
        $result  = [
            "icon_path" => "https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/marketing/",
            "items" => []
        ];
		$args  = array(
			'post_type'      => 'event_tab',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key'     => 'tab_type',
                    'value'   => 'type_10',
                    'compare' => '='
                )
            )
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

            $intervalId  = get_post_meta( get_the_ID(), 'mastak_event_tab_type_10_interval', true );
            $icon    = get_post_meta(  get_the_ID(), 'mastak_event_tab_type_10_icon', true );
            $description  = get_post_meta(  get_the_ID(), 'mastak_event_tab_type_10_description', true );
            $start  = get_post_meta(  $intervalId, 'season_from', true );
			$end    = get_post_meta(  $intervalId, 'season_to', true );

            $dateTo = new DateTime($end);
            $dateFrom = new DateTime($start);
            $period = new DatePeriod(
                $dateFrom->modify('-1 day'),
                new DateInterval('P1D'),
                $dateTo->modify('+1 day')
            );
    
            foreach ($period as $key => $value) {
                $result['items'][] = array(
                    'date'  => $value->format('Y-m-d'),
                    'icon'  => $icon,
                    'description' => $description
                ); 
            }			
		endwhile;
			wp_reset_postdata();
		endif;

        Log:info('Result', $result);
		return $result;
    }


// Add Shortcode
	function sbc_disaply_calendar( $atts ) {

		// Attributes
		$atts = shortcode_atts(
			array(
				'id'   => '',
				'slug' => '',
			),
			$atts,
			'sbc_calendar'
		);

		// Return only if has ID attribute
		if ( isset( $atts['id'] ) && isset( $atts['slug'] ) ) {
			return '<div class="calendar_block">
                <div id="calendar_' . $atts['id'] . '" data-url="/wp-json/calendars/' . $atts['slug'] . '">
                <div id="cloader" style="display:none;" ></div></div>
                <div class="calendar_legend">
                <ul>
                <li><b class="reserved"></b>Зарезервировано</li>
                <li><b class="prepaid"></b>Предоплачено</li>
                <li><b class="booked"></b>Оплачено</li>
                </ul>
                <div class="select-helper">
                    <img src="/wp-content/themes/krasnagorka/mastak/assets/icons/date-clicking-selecting.png" class="select-helper__img" alt="Выделение дат заезда и выезда">
                    <p class="select-helper__text" data-helper-start="'.get_option('mastak_theme_options')['calendar_settings_message'].'" data-helper="'.get_option('mastak_theme_options')['calendar_settings_message_after'].'">' . get_option('mastak_theme_options')['calendar_settings_message'].'</p>    
                </div>
                </div>
                </div>';
		}

	}

	add_shortcode( 'sbc_calendar', 'sbc_disaply_calendar' );

	function custom_column_header( $columns ) {

		$columns['sbc_shortcode'] = 'Shortcode';

		return $columns;
	}

	add_filter( "manage_edit-sbc_calendars_columns", 'custom_column_header', 10 );

	function sbc_calendars_id( $value, $column_name, $id ) {

		$shortcode = '';

		if ( $column_name === 'sbc_shortcode' ) {
			$term = get_term( $id, 'sbc_calendars' );
			$slug = $term->slug;

			$shortcode = '[sbc_calendar id="' . $id . '" slug="' . $slug . '"]';
		}

		return $shortcode;
	}

	add_action( "manage_sbc_calendars_custom_column", 'sbc_calendars_id', 10, 3 );

	add_action( 'restrict_manage_posts', 'client_taxonomy_filter' );

	function client_taxonomy_filter() {

		global $typenow; // this variable stores the current custom post type
		if ( $typenow == 'sbc_clients' ) { // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
			$taxonomy_names = array( 'sbc_clients_type' );
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


// Search on custom fields
	function custom_search_join( $join ) {

		global $pagenow, $wpdb;
		$types = [ 'sbc_orders', 'sbc_clients' ];
		// I want the filter only when performing a search on edit page of Custom Post Type in $types array
		if ( is_admin() && $pagenow == 'edit.php' && in_array( $_GET['post_type'], $types ) && isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {
			$join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}

		return $join;
	}

	add_filter( 'posts_join', 'custom_search_join' );

	function custom_search_where( $where ) {

		global $pagenow, $wpdb;
		$types = [ 'sbc_orders', 'sbc_clients' ];
		// I want the filter only when performing a search on edit page of Custom Post Type in $types array
		if ( is_admin() && $pagenow == 'edit.php' && in_array( $_GET['post_type'], $types ) && isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {

			$where = preg_replace(
				"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
		}

		return $where;
	}

	add_filter( 'posts_where', 'custom_search_where' );
	function custom_search_distinct( $where ) {

		global $pagenow, $wpdb;
		$types = [ 'sbc_orders', 'sbc_clients' ];
		if ( is_admin() && $pagenow == 'edit.php' && in_array( $_GET['post_type'], $types ) && isset( $_GET['s'] ) && ! empty( $_GET['s'] ) ) {
			return "DISTINCT";

		}

		return $where;
	}

	add_filter( 'posts_distinct', 'custom_search_distinct' );

	function render_client_orders( $field ) {

		global $pagenow;
		// validate page
		if ( in_array( $pagenow, array( 'post-new.php' ) ) ) {
			return;
		}

		$field = $field->args;
//		$id       = get_the_ID();
		$userName = get_the_title();
		echo '<div class="client_orders_list">';
		echo '<h3>' . $field['name'] . '</h3>';

		$args = array(
			'posts_per_page' => - 1,
			'post_type'      => 'sbc_orders',
			'post_status'    => array( 'publish', 'draft' ),
			'meta_key'       => 'sbc_order_client',
			'meta_value'     => $userName,
			'meta_compare'   => 'LIKE',
		);

		$query = get_posts( $args );

		echo '<div class="head_row"><div class="head_col col">Заголовок</div><div class="head_col col">Календарь</div>
<div class="head_col col">Статус</div><div class="head_col col">Дата заезд</div><div class="head_col col">Дата выезда</div>
<div class="head_col col">Цена</div><div class="head_col col">Lead Id</div><div class="head_col col">Предоплата</div><div class="head_col col">Комментарий</div></div>';

		if ( isset( $query ) && ! empty( $query ) ) :
			foreach ( $query as $post ) {
				echo '<div class="row">';
				$terms = get_the_terms( $post->ID, 'sbc_calendars' );
				echo '<div class="row_col col">';
				if ( get_the_title( $post->ID ) ) {
					echo get_the_title( $post->ID );
				} else {
					echo 'Пусто';
				}
				echo '</div>';
				echo '<div class="row_col col">';
				if ( $terms && ! is_wp_error( $terms ) ) :

					$draught_links = array();

					foreach ( $terms as $term ) {
						$draught_links[] = $term->name;
					}

					$on_draught = join( ", ", $draught_links );


					printf( esc_html__( '%s', 'sbc' ), esc_html( $on_draught ) );

				endif;
				echo '</div>';
				echo '<div class="row_col col">';
				$status = get_post_meta( $post->ID, 'sbc_order_select', true );
				switch ( $status ) {
					default:
						echo 'не установлен';
						break;
					case 'booked':
						echo 'Оплачено';
						break;
					case 'reserved':
						echo 'Зарезервировано';
						break;
					case 'prepaid':
						echo 'Предоплачено';
						break;
				}
				echo '</div>';
				echo '<div class="row_col col">' . get_post_meta( $post->ID, 'sbc_order_start', true ) . '</div>';
				echo '<div class="row_col col">' . get_post_meta( $post->ID, 'sbc_order_end', true ) . '</div>';
				echo '<div class="row_col col">' . get_post_meta( $post->ID, 'sbc_order_price', true ) . '</div>';
				echo '<div class="row_col col">' . get_post_meta( $post->ID, 'sbc_lead_id', true ) . '</div>';
				echo '<div class="row_col col">';
				if ( get_post_meta( $post->ID, 'sbc_order_prepaid', true ) ) {
					echo get_post_meta( $post->ID, 'sbc_order_prepaid', true );
				} else {
					echo '0';
				}
				echo '</div>';
				echo '<div class="row_col col">' . get_post_meta( $post->ID, 'sbc_order_desc', true ) . '</div>';
				echo '<a class="col_edit" target="_blank" href="' . get_edit_post_link( $post->ID ) . '"><span class="dashicons dashicons-edit"></span></a>';
				echo '</div>';
			}
		else :
			echo '<p>' . _e( 'У этого клиента еще нет заказов.' ) . '</p>';
		endif;

		echo '</div>';
	}

	add_filter( 'months_dropdown_results', '__return_empty_array' );

	function sbc_get_months() {

		global $wpdb;
		$months = wp_cache_get( 'sbc_months' );
		if ( false === $months ) {
			$query  = "SELECT YEAR(DATE_FORMAT(meta_value, '%Y-%m-%d')) AS `year`, MONTH(DATE_FORMAT(meta_value, '%Y-%m-%d')) AS `month`, count(post_id) as posts 
                FROM $wpdb->postmeta WHERE meta_key ='sbc_order_start'           
                GROUP BY YEAR(DATE_FORMAT(meta_value, '%Y-%m-%d')) , MONTH(DATE_FORMAT(meta_value, '%Y-%m-%d'))  ORDER BY meta_value DESC";
			$months = $wpdb->get_results( $query );
			wp_cache_set( 'sbc_months', $months );
		}

		return $months;
	}

	if ( ! wp_next_scheduled( 'order_start_date_hook' ) ) {
		wp_schedule_event( time(), 'daily', 'order_start_date_hook' );
	}
	add_action( 'order_start_date_hook', 'update_db_order_start_date' );

	if ( ! wp_next_scheduled( 'order_end_date_hook' ) ) {
		wp_schedule_event( time(), 'daily', 'order_end_date_hook' );
	}
	add_action( 'order_end_date_hook', 'update_db_order_end_date' );

	function update_db_order_start_date() {
		global $wpdb;
		$query  = "SELECT meta_id, post_id, meta_value FROM $wpdb->postmeta WHERE meta_key='sbc_order_start'";
		$months = $wpdb->get_results( $query );

		foreach ( $months as $key => $value ) {
			$date_old = $value->meta_value;
			$date_arr = explode( "-", $date_old );
			if ( strlen( $date_arr[2] ) == 4 ) {
				$new_date = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0];
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value='$new_date' WHERE meta_id=$value->meta_id" ) );
			}
			//echo "Старая дата  $date_old  Новая дата  $new_date \r\n";
		}
	}

	function update_db_order_end_date() {
		global $wpdb;
		$query  = "SELECT meta_id, post_id, meta_value FROM $wpdb->postmeta WHERE meta_key='sbc_order_end'";
		$months = $wpdb->get_results( $query );

		foreach ( $months as $key => $value ) {
			$date_old = $value->meta_value;
			$date_arr = explode( "-", $date_old );
			if ( strlen( $date_arr[2] ) == 4 ) {
				$new_date = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0];
				$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value='$new_date' WHERE meta_id=$value->meta_id" ) );
			}
			//echo "Старая дата  $date_old  Новая дата  $new_date \r\n";
		}
	}