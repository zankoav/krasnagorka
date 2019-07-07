<?php
	/**
	 * Created by PhpStorm.
	 * User: alexandrzanko
	 * Date: 7/31/18
	 * Time: 12:05 AM
	 */

	define( 'CORE_PATH', get_template_directory_uri() . '/mastak/' );

	$themeUri = get_template_directory_uri();

	require __DIR__ . "/core/custom_types.php";
	require __DIR__ . "/core/mastak_menu.php";

	require_once __DIR__ . "/core/cookie/BaseCookie.php";
	require_once __DIR__ . "/core/cookie/KGCookie.php";
	require_once __DIR__ . "/core/styles_and_scripts.php";
	require_once __DIR__ . "/core/ajax.php";

	require __DIR__ . "/core/cmb2/BaseMeta.php";
	require __DIR__ . "/core/cmb2/Type_1.php";
	require __DIR__ . "/core/cmb2/Type_2.php";
	require __DIR__ . "/core/cmb2/Type_3.php";
	require __DIR__ . "/core/cmb2/Type_4.php";
	require __DIR__ . "/core/cmb2/Type_5.php";
	require __DIR__ . "/core/cmb2/Type_6.php";
	require __DIR__ . "/core/cmb2/Type_7.php";
	require __DIR__ . "/core/cmb2/Type_8.php";

	$kgCooke = new KGCookie();

	add_action( 'mastak_tab_view', 'mastak_tab_pre_view', 10, 1 );

	function mastak_tab_pre_view( $id ) {
		$tab_type = get_post_meta( $id, 'tab_type', 1 );
		$tab      = null;
		switch ( $tab_type ) {
			case 'type_1':
				$tab = new Type_1( absint( $id ) );
				break;
			case 'type_2':
				$tab = new Type_2( absint( $id ) );
				break;
			case 'type_3':
				$tab = new Type_3( absint( $id ) );
				break;
			case 'type_4':
				$tab = new Type_4( absint( $id ) );
				break;
			case 'type_5':
				$tab = new Type_5( absint( $id ) );
				break;
			case 'type_6':
				$tab = new Type_6( absint( $id ) );
				break;
			case 'type_7':
				$tab = new Type_7( absint( $id ) );
				break;
			case 'type_8':
				$tab = new Type_8( absint( $id ) );
				break;
			default:
				break;
		}
		if ( ! $tab ) {
			return;
		}
		set_query_var( 'tab', $tab );
		get_template_part( 'mastak/views/tab-types/content-' . $tab_type );
	}


	/**
	 * Sample template tag function for outputting a cmb2 file_list
	 *
	 * @param  string $file_list_meta_key The field meta key. ('wiki_test_file_list')
	 * @param  string $img_size Size of image to show
	 */
	function get_model_gallary( $img_size = 'medium', $meta_key ) {

		// Get the list of files
		$files = get_post_meta( get_the_ID(), $meta_key, 1 );
		foreach ( (array) $files as $attachment_id => $attachment_url ) : ?>
            <div class="swiper-slide house-media-library__item">
                <a rel="group" href="<?= $attachment_url; ?>"
                   class="house-media-library__media-wrapper">
					<?= wp_get_attachment_image( $attachment_id, $img_size, false, array( 'class' => 'house-media-library__media' ) ); ?>
                </a>
            </div>
		<?php endforeach;
	}

	function get_terem_gallary( $gallaries ) {
		// Get the list of files
		foreach ( $gallaries as $gallary ) : ?>
            <div class="swiper-slide house-media-library__item">

                <a rel="group" href="<?= $gallary; ?>"
                   class="house-media-library__media-wrapper">
                    <img src="<?= $gallary ?>" alt="Терем">
                </a>
            </div>
		<?php endforeach;
	}


	function mastak_get_house_rooms() {
// Get the list of files
		$entries = get_post_meta( get_the_ID(), 'room', true );

		$rooms = [];

		foreach ( (array) $entries as $key => $entry ) {

			$room = '';

			if ( isset( $entry['item'] ) ) {
				$room = esc_html( $entry['item'] );
			}
			$rooms[] = $room;
			// Do something with the data
		}

		return $rooms;
	}

	function mastak_get_house_conveniences() {
// Get the list of files
		$entries = get_post_meta( get_the_ID(), 'convenience', true );

		$conveniences = [];

		foreach ( (array) $entries as $key => $entry ) {

			$convenience = '';

			if ( isset( $entry['item'] ) ) {
				$convenience = esc_html( $entry['item'] );
			}
			$conveniences[] = $convenience;
			// Do something with the data
		}

		return $conveniences;
	}

	function mastak_get_house_kitchen() {
// Get the list of files
		$entries = get_post_meta( get_the_ID(), 'kitchen', true );

		$conveniences = [];

		foreach ( (array) $entries as $key => $entry ) {

			$convenience = '';

			if ( isset( $entry['item'] ) ) {
				$convenience = esc_html( $entry['item'] );
			}
			$conveniences[] = $convenience;
			// Do something with the data
		}

		return $conveniences;
	}

	function mastak_get_house_bathroom() {
// Get the list of files
		$entries = get_post_meta( get_the_ID(), 'bathroom', true );

		$conveniences = [];

		foreach ( (array) $entries as $key => $entry ) {

			$convenience = '';

			if ( isset( $entry['item'] ) ) {
				$convenience = esc_html( $entry['item'] );
			}
			$conveniences[] = $convenience;
			// Do something with the data
		}

		return $conveniences;
	}

	function mastak_get_event_tabs() {
// Get the list of files
		$entries = get_post_meta( get_the_ID(), 'mastak_event_tabs_event_list', true );

		$tabs = [];

		foreach ( (array) $entries as $key => $entry ) {

			$tab = [];

			if ( isset( $entry['tab'] ) ) {
				$tab['id'] = esc_html( $entry['tab'] );
			}
			if ( isset( $entry['tab_name'] ) ) {
				$tab['name'] = esc_html( $entry['tab_name'] );
			}

			$tabs[] = $tab;
			// Do something with the data
		}

		return $tabs;
	}

	function get_current_month_rus() {
		$month_number = (int) date( 'n' );
		$_monthsList  = array(
			"Января",
			"Февраля",
			"Марта",
			"Апреля",
			"Мая",
			"Июня",
			"Июля",
			"Августа",
			"Сентября",
			"Октября",
			"Ноября",
			"Декабря"
		);

		return $_monthsList[ $month_number - 1 ];

	}

	function get_day_by_date_format( $date ) {
		$days = array( 'вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб' );

		return $days[ (int) date( 'w', strtotime( $date ) ) ];
	}

	function get_weather() {
		$weather = get_option( 'mastak_weather' );
		if ( ! empty( $weather ) ) {
			$weatherArray = json_decode( $weather, true );
			if ( $weatherArray === null or ( $weatherArray[0]["date"] < date( 'Y-m-d' ) ) ) {
				return update_mastak_weather();
			} else {
				return $weatherArray;
			}
		} else {
			return update_mastak_weather();
		}
	}

	function update_mastak_weather() {
		$result  = [];
		$api     = "http://api.apixu.com/v1/forecast.json?key=9bdc2c025cdf4992803115130182008&q=%D0%91%D1%80%D0%B0%D1%81%D0%BB%D0%B0%D0%B2&days=4&lang=ru";
		$weather = json_decode( file_get_contents( $api ), true );

		if ( ! empty( $weather ) and isset( $weather["forecast"] ) and isset( $weather["forecast"]["forecastday"] ) ) {

			$days = $weather["forecast"]["forecastday"];
			foreach ( $days as &$day ) {
				$result[] = [
					"date"    => $day["date"],
					"text"    => $day["day"]["condition"]["text"],
					"weekday" => get_day_by_date_format( $day["date"] ),
					"temp"    => round( $day["day"]["maxtemp_c"] ),
					"icon"    => $day["day"]["condition"]["icon"]
				];
			}
		}

		update_option( 'mastak_weather', json_encode( $result ) );

		return $result;
	}

	function get_current_price( $byn ) {

		global $kgCooke;
		$current_currency = $kgCooke->getCurrnecy();

		if ( $current_currency["currency_selected"] === KGCookie::RUS ) {

		    $price = (float)( $byn * 100 / $current_currency["currency"] );
            $price = number_format((float)$price, 2, '.', '');
			return $price;

		} else {

            $price = (float)( $byn / $current_currency["currency"] );
            $price = number_format((float)$price, 2, '.', '');

			return $price;

		}

	}

    function map_widgets_init() {

        register_sidebar( array(
            'name'          => 'Страница Местоположения Дома - текстовая область',
            'id'            => 'map-content',
            'before_widget' => '<div class="big-text content-text">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
            'after_title'   => '</h2></div>',
        ) );

    }

    function map_2_widgets_init() {

        register_sidebar( array(
            'name'          => 'Страница Местоположения Услуги - текстовая область',
            'id'            => 'map-2-content',
            'before_widget' => '<div class="big-text content-text">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
            'after_title'   => '</h2></div>',
        ) );

    }

    add_action( 'widgets_init', 'map_widgets_init' );
    add_action( 'widgets_init', 'map_2_widgets_init' );

    function home_widgets_init() {

        register_sidebar( array(
            'name'          => 'Главная страница - текстовая область',
            'id'            => 'home-content',
            'before_widget' => '<div class="b-container content-text b-pb-2">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="header-title"><p class="header-title__subtitle">',
            'after_title'   => '</p></div>',
        ) );

    }

    add_action( 'widgets_init', 'home_widgets_init' );

    function price_widgets_init() {

        register_sidebar( array(
            'name'          => 'Страница цен - текстовая область',
            'id'            => 'prices-content',
            'before_widget' => '<div class="b-container content-text season-text">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
            'after_title'   => '</h2></div>',
        ) );

    }

    add_action( 'widgets_init', 'price_widgets_init' );


	function our_house_widgets_init() {

		register_sidebar( array(
			'name'          => 'Наши дома текстовая область',
			'id'            => 'our-houses-content',
			'before_widget' => '<div class="b-container content-text">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
			'after_title'   => '</h2></div>',
		) );

	}

    add_action( 'widgets_init', 'our_house_widgets_init' );

	function opportunities_widgets_init() {

		register_sidebar( array(
			'name'          => 'Услуги текстовая область',
			'id'            => 'opportunities-content',
			'before_widget' => '<div class="b-container content-text">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="header-title"><h2 class="header-title__subtitle">',
			'after_title'   => '</h2></div>',
		) );

	}

    add_action( 'widgets_init', 'opportunities_widgets_init' );



	function events_widgets_init() {

		register_sidebar( array(
			'name'          => 'Мероприятия текстовая область',
			'id'            => 'events-content',
			'before_widget' => '<section class="b-container big-text">
                                    <div class="big-text__container content-text">',
			'after_widget'  => '</div>
                                    <div class="show-more">
                                        <div class="show-more__button">
                                            <div class="show-more__dote"></div>
                                            <div class="show-more__dote"></div>
                                            <div class="show-more__dote"></div>
                                        </div>
                                        <span class="show-more__title">Показать еще</span>
                                    </div>
                                </section>',
			'before_title'  => '<section class="header-title">
                                    <h2 class="header-title__subtitle">',
			'after_title'   => '</h2></section>',
		) );

	}

    add_action( 'widgets_init', 'events_widgets_init' );


	function get_mastak_header_small_view_image() {
        if ( is_post_type_archive( 'house' ) ) {
			return get_option( 'mastak_houses_appearance_options' )['mastak_house_submenu_header_image_id'];
		} else if ( is_post_type_archive( 'opportunity' ) ) {
            return get_option( 'mastak_opportunities_appearance_options' )['mastak_opportunity_submenu_header_image_id'];
		} else if ( is_post_type_archive( 'event' ) ) {
            return get_option( 'mastak_event_appearance_options' )['mastak_event_submenu_header_image_id'];
		} else if ( is_singular( 'house' ) ) {
            return get_post_meta( get_the_ID(), "mastak_house_header_image_id", true );
		} else if ( is_singular( 'opportunity' ) ) {
            return get_post_meta( get_the_ID(), "mastak_opportunity_header_image_id", true );
		} else if ( is_singular( 'event' ) ) {
            return get_post_meta( get_the_ID(), "mastak_event_header_image_id", true );
		} else if ( is_page_template( "template-mastak-prices.php" ) ) {
            return get_option( 'mastak_price_appearance_options' )['mastak_price_submenu_header_image_id'];
		} else if ( is_page_template( "reviews-page-template.php" ) ) {
            return get_option( 'mastak_reviews_appearance_options' )['mastak_reviews_image_id'];
		} else if ( is_page_template( "template-mastak-booking.php" ) ) {
            return get_option( 'mastak_booking_appearance_options' )['mastak_booking_image_id'];
		} else if ( is_page_template( "template-mastak-map.php" ) ) {
            return get_option( 'mastak_map_appearance_options' )['mastak_map_image_id'];
		} else if ( is_page_template( "mastak-page-default-template.php" ) ) {
            return get_post_thumbnail_id();
		}else if ( is_404() ) {
            return get_option( 'mastak_theme_options' )['bgimage_404_id'];
		} else {
            return null;
		}
	}

    add_filter( 'mastak_header_small_view_image', 'get_mastak_header_small_view_image' );

	function get_mastak_header_small_view_title() {
		if ( is_post_type_archive( 'house' ) ) {
			echo '<p class="main-slide__slide-content-title">',
			get_option( 'mastak_houses_appearance_options' )['mastak_house_submenu_header_title'],
			'</p>';
		} else if ( is_post_type_archive( 'opportunity' ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_option( 'mastak_opportunities_appearance_options' )['mastak_opportunity_submenu_header_title'],
			'</h1>';
		} else if ( is_post_type_archive( 'event' ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_option( 'mastak_event_appearance_options' )['mastak_event_submenu_header_title'],
			'</h1>';
		} else if ( is_singular( 'house' ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_post_meta( get_the_ID(), "mastak_house_header_title", true ),
			'</h1>';
		} else if ( is_singular( array( 'opportunity', 'event' ) ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h1>';
		} else if ( is_page_template( "template-mastak-prices.php" ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h1>';
		} else if ( is_page_template( "reviews-page-template.php" ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h1>';
		} else if ( is_page_template( "template-mastak-booking.php" ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h1>';
		} else if ( is_page_template( "template-mastak-map.php" ) ) {
			echo '<h1 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h1>';
		} else if ( is_page_template( "mastak-page-default-template.php" ) ) {
			echo '<h2 class="main-slide__slide-content-title">',
			get_the_title(),
			'</h2>';
		} else if ( is_404() ) {
			echo '<h1 class="main-slide__slide-content-title">',
            get_option( 'mastak_theme_options' )['title_404'],
			'</h1>';
		} else {
			echo '<h2 class="main-slide__slide-content-title">',
			"#",
			'</h2>';
		}
	}

	add_action( 'mastak_header_small_view_title', 'get_mastak_header_small_view_title' );


	function sort_opportunities( $query ) {
		if ( $query->is_post_type_archive( 'opportunity' ) && $query->is_main_query() ) {
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'meta_key', 'mastak_opportunity_added_opportunity' );
		}
	}

	add_action( 'pre_get_posts', 'sort_opportunities' );


	function mastak_remove_comment_fields( $fields ) {
		if ( is_page_template( 'reviews-page-template.php' ) ) {
			unset( $fields['url'] );
			unset( $fields['email'] );


			$fields['author'] = '<div class="review-form__wrapper">
                    <div class="review-form__item review-form__item_horizontal_item">
                        <label for="author">Ваше имя</label>
                        <input type="text" id="author" name="author" class="review-form__input b-p-25" required>
                    </div>';

			$fields['like_email'] = '<div class="review-form__item review-form__item_horizontal_item">
                        <label for="review-form-question">Email</label>
                        <input type="email" name="like_email" class="review-form__input b-p-25" id="review-form-question">
                    </div>
                </div>';

		}

		return $fields;
	}

	add_filter( 'comment_form_default_fields', 'mastak_remove_comment_fields' );

	add_filter( 'comment_form_defaults', 'mastak_comment_form_defaults', 100 );


	function mastak_comment_form_defaults( $defaults ) {
		if ( is_page_template( 'reviews-page-template.php' ) ) {
			$defaults['title_reply']          = '<p class="review-form__subtitle">Понравилось у нас?</p>';
			$defaults['comment_notes_before'] = '<p class="review-form__description">
                                        Дорогие гости, помогите нам стать еще лучше! Оставьте ваши отзывы о нашей базе отдыха, заполнив
                                        форму
                                        ниже. Нам важно ваше мнение.
			            </p>';

		}

		return $defaults;
	}

	function mastak_comment_form_defaults_2( $defaults ) {
		if ( is_page_template( 'reviews-page-template.php' ) ) {
			$options                          = get_option( 'mastak_reviews_appearance_options' );
			$defaults['title_reply']          = '<p class="review-form__subtitle review-form__subtitle_success">' . $options["title_success"] . '</p>';
			$defaults['comment_notes_before'] = '<p class="review-form__description">' . $options["subtitle_success"] . '</p>';
		}

		return $defaults;
	}


	add_action( 'comment_post', 'save_extend_comment_meta_data', 10, 3 );
	/**
	 * Сохраняет содержимое поля "Телефон" в метаполе.
	 *
	 * @param int $comment_id Идентификатор комментария
	 */
	function save_extend_comment_meta_data( $comment_id, $comment_approved, $commentdata ) {

		if ( ! empty( $_POST['like_email'] ) ) {
			$like_email = sanitize_text_field( $_POST['like_email'] );
			add_comment_meta( $comment_id, 'like_email', $like_email );
		}

		if ( ! empty( $_POST['rating_reviews'] ) ) {
			$rating_reviews = sanitize_text_field( $_POST['rating_reviews'] );
			add_comment_meta( $comment_id, 'rating_reviews', $rating_reviews );
		}

		$rating          = isset( $_POST['rating_reviews'] ) ? $_POST['rating_reviews'] : '0';
		$commentText     = $commentdata['comment_content'];
		$options         = get_option( 'mastak_theme_options' );
		$commentsEmail   = isset( $options['mastak_theme_options_comment_email'] ) ? $options['mastak_theme_options_comment_email'] : false;
		$commentsCcEmail = isset( $options['mastak_theme_options_comment_email_2'] ) ? $options['mastak_theme_options_comment_email_2'] : false;


		if ( empty( $commentsEmail ) or ( $comment_approved === 'spam' ) ) {
			file_put_contents( __DIR__ . '/gg.txt', $comment_approved . ' - ' . $commentsEmail );

			return;
		}

		file_put_contents( __DIR__ . '/gg.txt', 'send 5' );


		$headers = array();

		if ( ! empty( $commentsCcEmail ) ) {
			$headers[] = 'Cc:' . $commentsCcEmail;
		}

		$isSend = wp_mail( $commentsEmail,
			'Новый отзыв на сайте krasnagorka.by',
			"   <h4>На сайте krasnagorka.by новый отзыв</h4>
                        <p>Оценка <b>$rating</b></p>
                        <p>Текст: <br>$commentText</p>
                        <a style='color:#FF4500;' href='https://krasnagorka.by/stranitsa-otzyvov/' target='_blank'>Посмотреть отзывы</a>",
			$headers
		);

		if ( $isSend ) {
			add_action( 'set_comment_cookies', function ( $comment, $user ) {
				setcookie( 'mastak_comment_wait_approval', '1', 0, '/' );
			}, 10, 2 );
		}
	}


	add_action( 'init', function () {
		if ( isset( $_COOKIE['mastak_comment_wait_approval'] ) && $_COOKIE['mastak_comment_wait_approval'] === '1' ) {
			setcookie( 'mastak_comment_wait_approval', '0', 0, '/' );
			add_filter( 'comment_form_defaults', 'mastak_comment_form_defaults_2', 200 );
		}
	} );

	add_action( 'wp_insert_comment', 'action_function_name_9983', 10, 2 );
	function action_function_name_9983( $id, $comment ) {
		$parentId = $comment->comment_parent;
		if ( ! empty( $parentId ) and $parentId != "0" ) {
			$parentComment = get_comment( $parentId );
			$email_autor   = $parentComment->comment_author_email;
			wp_mail( $email_autor,
				'Krasnagorka.by ответ на комментарий',
				"   <h4>На сайте krasnagorka.by ответ на Ваш комментарий</h4>
                            <p style='border:1px solid #A0A0A0; padding: 1rem;'>$parentComment->comment_content</p>
                            <p style='border:1px solid #81cb98; padding: 1rem;'>$comment->comment_content</p>
                       <a style='color:#FF4500;' href='https://krasnagorka.by/stranitsa-otzyvov/' target='_blank'>Посмотреть ответ</a>"
			);
		}
	}


	add_filter( 'wp_mail_content_type', function ( $content_type ) {
		return "text/html";
	} );


	add_filter( 'comment_form_fields', 'mastak_reorder_comment_fields' );
	function mastak_reorder_comment_fields( $fields ) {

		if ( is_page_template( 'reviews-page-template.php' ) ) {
			// die(print_r( $fields )); // посмотрим какие поля есть

			$new_fields = array(); // сюда соберем поля в новом порядке

			$myorder = array( 'author', 'like_email', 'rating_reviews', 'comment' ); // нужный порядок

			foreach ( $myorder as $key ) {
				$new_fields[ $key ] = $fields[ $key ];
				unset( $fields[ $key ] );
			}

			// если остались еще какие-то поля добавим их в конец
			if ( $fields ) {
				foreach ( $fields as $key => $val ) {
					$new_fields[ $key ] = $val;
				}
			}

			return $new_fields;
		}

		return $fields;
	}

	add_action( 'comment_form_logged_in_after', 'mastak_additional_fields' );
	add_action( 'comment_form_after_fields', 'mastak_additional_fields' );

	function mastak_additional_fields() {

		if ( is_page_template( 'reviews-page-template.php' ) ) {
			echo '<div class="review-form__item">
                    <label>Оценка</label>
                    <div class="star-rating">
                        <input class="star-rating__input" id="star-rating-5" type="radio" name="rating_reviews" value="5">
                        <label class="star-rating__ico  fas fa-star " for="star-rating-5" title="5 из 5"></label>
                        <input class="star-rating__input" id="star-rating-4" type="radio" name="rating_reviews" value="4">
                        <label class="star-rating__ico  fas fa-star " for="star-rating-4" title="4 из 5"></label>
                        <input class="star-rating__input" id="star-rating-3" type="radio" name="rating_reviews" value="3">
                        <label class="star-rating__ico  fas fa-star " for="star-rating-3" title="3 из 5"></label>
                        <input class="star-rating__input" id="star-rating-2" type="radio" name="rating_reviews" value="2">
                        <label class="star-rating__ico  fas fa-star " for="star-rating-2" title="2 из 5"></label>
                        <input class="star-rating__input" id="star-rating-1" type="radio" name="rating_reviews" value="1">
                        <label class="star-rating__ico  fas fa-star " for="star-rating-1" title="1 из 5"></label>
                    </div>
                </div>';
		}
	}


	function mastak_add_comments_columns( $columns ) {
		$preview = array( 'rating' => 'Звезды' );
		$like    = array( 'review_like' => 'Email' );
		$columns = array_slice( $columns, 1, 1, true ) + $preview + $like + array_slice( $columns, 1, null, true );

		return $columns;
	}

	add_filter( "manage_edit-comments_columns", 'mastak_add_comments_columns' );


	function mastak_fill_columns( $column, $id ) {
		switch ( $column ) {
			case 'rating':
				echo get_comment_meta( $id, 'rating_reviews', 1 );
				break;
			case 'review_like':
				echo get_comment_meta( $id, 'like_email', 1 );
				break;
			default:
				break;
		}
	}

	add_action( "manage_comments_custom_column", 'mastak_fill_columns', 10, 2 );

	function getStars( $count ) {
		for ( $i = 1; $i <= 5; $i ++ ): ?>
            <img src="<?= CORE_PATH; ?>assets/icons/<?= $i <= $count ? "" : "empty-"; ?>star.svg"
                 alt="star"
                 class="review__star">
		<?php endfor;
	}


	function dimox_breadcrumbs() {

		/* === OPTIONS === */
		$text['home'] = 'Главная'; // текст ссылки "Главная"

		$text['category'] = 'Архив рубрики "%s"'; // текст для страницы рубрики

		$text['search'] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска

		$text['tag'] = 'Записи с тегом "%s"'; // текст для страницы тега

		$text['author'] = 'Статьи автора %s'; // текст для страницы автора

		$text['404'] = 'Ошибка 404'; // текст для страницы 404

		$show_current = 1; // 1 - показывать название текущей статьи/страницы/рубрики, 0 - не показывать

		$show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать

		$show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать

		$show_title = 1; // 1 - показывать подсказку (title) для ссылок, 0 - не показывать

		$delimiter = '&nbsp;&nbsp;/&nbsp;&nbsp;'; //' &raquo; '; // разделить между "крошками"

		$before = '<span class="current">'; // тег перед текущей "крошкой"

		$after = '</span>'; // тег после текущей "крошки"

		/* === END OF OPTIONS === */

		global $post;

		$home_link = home_url( '/' );

		$link_before = '<span typeof="v:Breadcrumb">';

		$link_after = '</span>';

		$link_attr = ' rel="v:url" property="v:title"';

		$link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;

		$parent_id = $parent_id_2 = $post->post_parent;

		$frontpage_id = get_option( 'page_on_front' );

		if ( is_home() || is_front_page() ) {

			if ( $show_on_home == 1 ) {
				echo '<div><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
			}

		} else {

			echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';

			if ( $show_home_link == 1 ) {

				echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';

				if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) {
					echo $delimiter;
				}

			}

			if ( is_category() ) {

				$this_cat = get_category( get_query_var( 'cat' ), false );

				if ( $this_cat->parent != 0 ) {

					$cats = get_category_parents( $this_cat->parent, true, $delimiter );

					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					}

					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );

					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}

					echo $cats;

				}

				if ( $show_current == 1 ) {
					echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
				}

			} elseif ( is_search() ) {

				echo $before . sprintf( $text['search'], get_search_query() ) . $after;

			} elseif ( is_day() ) {

				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;

				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;

				echo $before . get_the_time( 'd' ) . $after;

			} elseif ( is_month() ) {

				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;

				echo $before . get_the_time( 'F' ) . $after;

			} elseif ( is_year() ) {

				echo $before . get_the_time( 'Y' ) . $after;

			} elseif ( is_single() && ! is_attachment() ) {

				if ( get_post_type() != 'post' ) {

					$post_type = get_post_type_object( get_post_type() );

					$slug = $post_type->rewrite;

					printf( $link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->menu_name );

					if ( $show_current == 1 ) {
						echo $delimiter . $before . get_the_title() . $after;
					}

				} else {

					$cat = get_the_category();
					$cat = $cat[0];

					$cats = get_category_parents( $cat, true, $delimiter );

					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
					}

					$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );

					$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

					if ( $show_title == 0 ) {
						$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
					}

					echo $cats;

					if ( $show_current == 1 ) {
						echo $before . get_the_title() . $after;
					}

				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {

				$post_type = get_post_type_object( get_post_type() );

				echo $before . $post_type->labels->menu_name . $after;

			} elseif ( is_attachment() ) {

				$parent = get_post( $parent_id );

				$cat = get_the_category( $parent->ID );
				$cat = $cat[0];

				$cats = get_category_parents( $cat, true, $delimiter );

				$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );

				$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

				if ( $show_title == 0 ) {
					$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
				}

				echo $cats;

				printf( $link, get_permalink( $parent ), $parent->post_title );

				if ( $show_current == 1 ) {
					echo $delimiter . $before . get_the_title() . $after;
				}

			} elseif ( is_page() && ! $parent_id ) {

				if ( $show_current == 1 ) {
					echo $before . get_the_title() . $after;
				}

			} elseif ( is_page() && $parent_id ) {

				if ( $parent_id != $frontpage_id ) {

					$breadcrumbs = array();

					while ( $parent_id ) {

						$page = get_page( $parent_id );

						if ( $parent_id != $frontpage_id ) {

							$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );

						}

						$parent_id = $page->post_parent;

					}

					$breadcrumbs = array_reverse( $breadcrumbs );

					for ( $i = 0; $i < count( $breadcrumbs ); $i ++ ) {

						echo $breadcrumbs[ $i ];

						if ( $i != count( $breadcrumbs ) - 1 ) {
							echo $delimiter;
						}

					}

				}

				if ( $show_current == 1 ) {

					if ( $show_home_link == 1 || ( $parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) {
						echo $delimiter;
					}

					echo $before . get_the_title() . $after;

				}

			} elseif ( is_tag() ) {

				echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;

			} elseif ( is_author() ) {

				global $author;

				$userdata = get_userdata( $author );

				echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;

			} elseif ( is_404() ) {

				echo $before . $text['404'] . $after;

			}

			if ( get_query_var( 'paged' ) ) {

				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}

				echo __( 'Page' ) . ' ' . get_query_var( 'paged' );

				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}

			}

			echo '</div><!-- .breadcrumbs -->';

		}

	} // end dimox_breadcrumbs()


	function get_all_opportunity_posts( $query ) {
		if ( $query->is_main_query() && is_post_type_archive( 'opportunity' ) ) {
			$query->set( 'posts_per_page', '-1' );
		}
	}

	add_action( 'pre_get_posts', 'get_all_opportunity_posts' );


    function mastak_seo_meta_title(){

        if(is_post_type_archive('event')){
            $keywords = get_option('mastak_event_appearance_options')['mastak_event_submenu_seo_keywords'];
            return  $keywords ? $keywords : '';
        }elseif(is_post_type_archive('house')){
            $keywords = get_option('mastak_houses_appearance_options')['mastak_house_submenu_seo_keywords'];
            return  $keywords ? $keywords : '';
        }elseif(is_post_type_archive('opportunity')){
            $keywords = get_option('mastak_opportunities_appearance_options')['mastak_opportunity_submenu_seo_keywords'];
            return  $keywords ? $keywords : '';
        }else{
            return '';
        }
    }

    add_action( 'after_setup_theme', 'zankoav_theme_init' );
    add_theme_support( 'post-thumbnails' );

    function zankoav_theme_init() {
        
        add_image_size( 'footer-logo', 160, 160, false );


        /**
         * Header sizes
         */
        add_image_size( 'header_iphone_5', 320, 568,  array( 'center', 'center' ) );
        add_image_size( 'header_iphone_6_plus', 414, 736,  array( 'center', 'center' ) );
        add_image_size( 'header_tablet_p', 768, 1024, array( 'center', 'center' ) );
        add_image_size( 'header_tablet_l', 1024, 768, array( 'center', 'center' ) );
        add_image_size( 'header_laptop', 1280 );
        add_image_size( 'header_laptop_xl', 1440 );
        add_image_size( 'header_laptop_hd', 1920 );

        /**
         * Opportunity sizes
         */

        add_image_size( 'opportunity_small_iphone_5', 280, 180,  array( 'center', 'center' ) );
        add_image_size( 'opportunity_small_iphone_6_plus', 370, 220,  array( 'center', 'center' ) );
        add_image_size( 'opportunity_small_laptop', 250, 250,  array( 'center', 'center' ) );

        /**
         * About us sizes
         */
        add_image_size( 'about_us_iphone_5', 320);
        add_image_size( 'about_us_tablet', 590);
        add_image_size( 'about_us_laptop', 960);

        /**
         * Map sizes
         */
        add_image_size( 'map_iphone_5', 272);
        add_image_size( 'map_laptop', 738);

        /**
         * Booking sizes
         */
        add_image_size( 'calendar-thumb', 330, 100, array( 'center', 'center' ) );

        /**
         * Opportunities sizes
         */
        add_image_size( 'icon-64', 64);

        /**
         * Events sizes
         */
        add_image_size( 'events_last_iphone_5', 250, 200, array( 'center', 'center' ));
        add_image_size( 'events_last_laptop', 135, 90, array( 'center', 'center' ));

        /**
         * Houses sizes
         */
        add_image_size( 'houses_last_iphone_5', 320, 240, array( 'center', 'center' ));
        add_image_size( 'houses_last_laptop', 300, 420, array( 'center', 'center' ));

        /**
         * Welcome tab
         */
        add_image_size( 'welcome_tab_iphone_5', 320, 214, array( 'center', 'center' ));
        add_image_size( 'welcome_tab_laptop', 240, 160, array( 'center', 'center' ));

    }

    if ( ! function_exists( 'presscore_blog_title' ) ) :

        /**
         * Display blog title.
         *
         */
        function presscore_blog_title() {
            $wp_title = wp_title('', false);
            $title = get_bloginfo('name') . ' | ';
            $title .= (is_front_page()) ? get_bloginfo('description') : $wp_title;

            return apply_filters( 'presscore_blog_title', $title, $wp_title );
        }

    endif;

    function house_archive_per_page( $query ) {
        if ($query->is_main_query() and !is_admin() and ('nav_menu_item' !== $query->get('post_type'))) {
            if($query->is_post_type_archive( 'house' )){
                $query->set( 'meta_key', 'mastak_house_order' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'ASC' );
            }else if($query->is_post_type_archive( 'opportunity' )){
                $query->set( 'meta_key', 'mastak_opportunity_order' );
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'ASC' );
            }
        }
    }
    add_filter( 'pre_get_posts', 'house_archive_per_page' );