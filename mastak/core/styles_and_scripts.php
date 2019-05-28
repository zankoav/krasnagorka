<?php


	add_action( 'wp_enqueue_scripts', function () {

		global $themeUri;

		if ( is_singular( 'house' ) ) {

			add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );
			add_action( 'wp_enqueue_scripts', 'give_dequeue_plugin_css', 100 );

			add_filter( 'wp_get_attachment_image_src', 'delete_width_height', 10, 4 );

			$scriptsData = get_assets_json( "house" );
			wp_enqueue_script( 'zoom', $themeUri . '/mastak/src/js/jquery.zoom.min.js', false, null, true );

			wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

			wp_enqueue_style( 'house', $themeUri . '/mastak' . $scriptsData["house"]["css"], false, null );
			wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsData["house"]["js"], false, null, true );

			wp_dequeue_script( 'public_calendar' ); //If you're using disqus, etc.

			add_yandex_map();
		}

		if ( is_singular( array( 'opportunity', 'event' ) ) ) {

			add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );
			add_action( 'wp_enqueue_scripts', 'give_dequeue_plugin_css', 100 );

			add_filter( 'wp_get_attachment_image_src', 'delete_width_height', 10, 4 );

			$scriptsData = get_assets_json( "house" );
			
			wp_enqueue_script( 'zoom', $themeUri . '/mastak/src/js/jquery.zoom.min.js', false, null, true );

			wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

			wp_enqueue_style( 'house', $themeUri . '/mastak' . $scriptsData["house"]["css"], false, null );
			wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsData["house"]["js"], false, null, true );

			wp_dequeue_script( 'public_calendar' ); //If you're using disqus, etc.

			add_yandex_map();
		}

		if ( is_post_type_archive( 'house' ) ) {

			add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );
			add_action( 'wp_enqueue_scripts', 'give_dequeue_plugin_css', 100 );

			add_filter( 'wp_get_attachment_image_src', 'delete_width_height', 10, 4 );

			$scriptsData = get_assets_json( "houses" );
            $scriptsHouseData = get_assets_json( "house" );


            wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

			wp_enqueue_style( 'houses', $themeUri . '/mastak' . $scriptsData["houses"]["css"], false, null );
			wp_enqueue_script( 'houses', $themeUri . '/mastak' . $scriptsData["houses"]["js"], false, null, true );
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );

			add_yandex_map();
		}

		if ( is_post_type_archive( 'event' ) ) {

			add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );
			add_action( 'wp_enqueue_scripts', 'give_dequeue_plugin_css', 100 );

			add_filter( 'wp_get_attachment_image_src', 'delete_width_height', 10, 4 );

			$scriptsData = get_assets_json( "events" );
            $scriptsHouseData = get_assets_json( "house" );

			wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

			wp_enqueue_style( 'events', $themeUri . '/mastak' . $scriptsData["events"]["css"], false, null );
			wp_enqueue_script( 'events', $themeUri . '/mastak' . $scriptsData["events"]["js"], false, null, true );
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );


			add_yandex_map();
		}

		if ( is_post_type_archive( 'opportunity' ) ) {

			add_action( 'wp_print_scripts', 'my_site_WI_dequeue_script', 100 );
			add_action( 'wp_enqueue_scripts', 'give_dequeue_plugin_css', 100 );

			add_filter( 'wp_get_attachment_image_src', 'delete_width_height', 10, 4 );

			$scriptsData = get_assets_json( "opportunities" );
            $scriptsHouseData = get_assets_json( "house" );

			wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

			wp_enqueue_style( 'opportunities', $themeUri . '/mastak' . $scriptsData["opportunities"]["css"], false, null );
			wp_enqueue_script( 'opportunities', $themeUri . '/mastak' . $scriptsData["opportunities"]["js"], false, null, true );

			wp_dequeue_script( 'public_calendar' ); //If you're using disqus, etc.
			wp_dequeue_script( 'moment' ); //If you're using disqus, etc.
			wp_dequeue_script( 'fullcalendar_locale' ); //If you're using disqus, etc.
			wp_dequeue_script( 'fullcalendar' ); //If you're using disqus, etc.
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );

			add_yandex_map();
		}



		if ( is_page_template( 'template-mastak-booking.php' ) ) {

			$scriptsData = get_assets_json( "booking" );
            $scriptsHouseData = get_assets_json( "house" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');
            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
			wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );
			wp_enqueue_script( 'booking', $themeUri . '/mastak' . $scriptsData["booking"]["js"], false, null, true );
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );

            wp_enqueue_style( 'booking', $themeUri . '/mastak' . $scriptsData["booking"]["css"], false, null );
            wp_dequeue_style('contact-form-7');

            wp_add_inline_style('booking',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );

		}

		if ( is_page_template( 'template-mastak-map.php' ) ) {

			$scriptsData = get_assets_json( "booking" );
            $scriptsHouseData = get_assets_json( "house" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');
            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
            wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );
            wp_enqueue_script( 'booking', $themeUri . '/mastak' . $scriptsData["booking"]["js"], false, null, true );
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );

			wp_enqueue_style( 'booking', $themeUri . '/mastak' . $scriptsData["booking"]["css"], false, null );

            wp_dequeue_script( 'public_calendar' );
            wp_dequeue_script( 'moment' );
            wp_dequeue_script( 'fullcalendar_locale' );
            wp_dequeue_script( 'fullcalendar' );

            wp_dequeue_style('fullcalendar_public_style');
            wp_dequeue_style('contact-form-7');

            wp_add_inline_style('booking',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );
		}

		if ( is_page_template( 'reviews-page-template.php' ) ) {


			$scriptsData = get_assets_json( "reviews" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');
            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
            wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );
			wp_enqueue_script( 'reviews', $themeUri . '/mastak' . $scriptsData["reviews"]["js"], false, null, true );

            wp_dequeue_script( 'public_calendar' );
            wp_dequeue_script( 'moment' );
            wp_dequeue_script( 'fullcalendar_locale' );
            wp_dequeue_script( 'fullcalendar' );
            wp_dequeue_script('jquery-fancybox');
            wp_dequeue_script('jquery-easing');
            wp_dequeue_script('jquery-mousewheel');

            wp_enqueue_style( 'reviews', $themeUri . '/mastak' . $scriptsData["reviews"]["css"], false, null );

            wp_dequeue_style('fancybox');
            wp_dequeue_style('fullcalendar_public_style');
            wp_dequeue_style('contact-form-7');


            wp_add_inline_style('reviews',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );
		}

		if ( is_page_template( 'mastak-page-default-template.php' ) ) {

			$scriptsData = get_assets_json( "reviews" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');

            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
            wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );

            wp_dequeue_script( 'public_calendar' );
            wp_dequeue_script( 'moment' );
            wp_dequeue_script( 'fullcalendar_locale' );
            wp_dequeue_script( 'fullcalendar' );
            wp_dequeue_script('jquery-fancybox');
            wp_dequeue_script('jquery-easing');
            wp_dequeue_script('jquery-mousewheel');

            wp_enqueue_style( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["css"], false, null );

            wp_dequeue_style('fancybox');
            wp_dequeue_style('fullcalendar_public_style');
            wp_dequeue_style('contact-form-7');

            wp_add_inline_style('commons',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );

        }

        if ( is_page_template( 'template-mastak-prices.php' ) ) {



            $scriptsData = get_assets_json( "prices" );
            $scriptsHouseData = get_assets_json( "house" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');

            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
            wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );
            wp_enqueue_script( 'prices', $themeUri . '/mastak' . $scriptsData["prices"]["js"], false, null, true );
            wp_enqueue_script( 'house', $themeUri . '/mastak' . $scriptsHouseData["house"]["js"], false, null, true );


            wp_dequeue_script( 'public_calendar' ); //If you're using disqus, etc.
            wp_dequeue_script( 'moment' ); //If you're using disqus, etc.
            wp_dequeue_script( 'fullcalendar_locale' ); //If you're using disqus, etc.
            wp_dequeue_script( 'fullcalendar' ); //If you're using disqus, etc.
            wp_dequeue_script('jquery-fancybox');
            wp_dequeue_script('jquery-easing');
            wp_dequeue_script('jquery-mousewheel');

            wp_enqueue_style( 'prices', $themeUri . '/mastak' . $scriptsData["prices"]["css"], false, null );

            wp_dequeue_style('fancybox');
            wp_dequeue_style('fullcalendar_public_style');
            wp_dequeue_style('contact-form-7');

            wp_add_inline_style('prices',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );

        }

        if ( is_page_template( 'home-page-template.php' ) or is_404() ) {


            $scriptsData = get_assets_json( "index" );

            wp_dequeue_script('jquery');
            wp_dequeue_script('jquery-core');
            wp_dequeue_script('jquery-migrate');
            wp_enqueue_script('jquery', false, array(), false, true);
            wp_enqueue_script('jquery-core', false, array(), false, true);
            wp_enqueue_script('jquery-migrate', false, array(), false, true);
            wp_enqueue_script( 'commons', $themeUri . '/mastak' . $scriptsData["common"]["js"], false, null, true );
            wp_enqueue_script( 'opportunities', $themeUri . '/mastak' . $scriptsData["index"]["js"], false, null, true );

            wp_dequeue_script( 'public_calendar' );
            wp_dequeue_script( 'moment' );
            wp_dequeue_script( 'fullcalendar_locale' );
            wp_dequeue_script( 'fullcalendar' );
            wp_dequeue_script('jquery-fancybox');
            wp_dequeue_script('jquery-easing');
            wp_dequeue_script('jquery-mousewheel');

            wp_enqueue_style( 'home', $themeUri . '/mastak' . $scriptsData["index"]["css"], false, null );

            wp_dequeue_style('fancybox');
            wp_dequeue_style('fullcalendar_public_style');
            wp_dequeue_style('contact-form-7');

            wp_add_inline_style('home',
                'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
            );

        }

	}, 100 );

    function prefix_add_footer_styles() {
        wp_add_inline_style('commons',
            'div.wpcf7{margin:0;padding:0}div.wpcf7 .screen-reader-response{position:absolute;overflow:hidden;clip:rect(1px,1px,1px,1px);height:1px;width:1px;margin:0;padding:0;border:0}div.wpcf7-response-output{margin:2em .5em 1em;padding:.2em 1em;border:2px solid red}div.wpcf7-mail-sent-ok{border:2px solid #398f14}div.wpcf7-aborted,div.wpcf7-mail-sent-ng{border:2px solid red}div.wpcf7-spam-blocked{border:2px solid orange}div.wpcf7-acceptance-missing,div.wpcf7-validation-errors{border:2px solid #f7e700}.wpcf7-form-control-wrap{position:relative}span.wpcf7-not-valid-tip{color:red;font-size:1em;font-weight:400;display:block}.use-floating-validation-tip span.wpcf7-not-valid-tip{position:absolute;top:20%;left:20%;z-index:100;border:1px solid red;background:#fff;padding:.2em .8em}span.wpcf7-list-item{display:inline-block;margin:0 0 0 1em}span.wpcf7-list-item-label::after,span.wpcf7-list-item-label::before{content:" "}.wpcf7-display-none{display:none}div.wpcf7 .ajax-loader{visibility:hidden;display:inline-block;background-image:url(/wp-content/plugins/contact-form-7/images/ajax-loader.gif);width:16px;height:16px;border:none;padding:0;margin:0 0 0 4px;vertical-align:middle}div.wpcf7 .ajax-loader.is-active{visibility:visible}div.wpcf7 div.ajax-error{display:none}div.wpcf7 .placeheld{color:#888}div.wpcf7 input[type=file]{cursor:pointer}div.wpcf7 input[type=file]:disabled{cursor:default}div.wpcf7 .wpcf7-submit:disabled{cursor:not-allowed}'
        );
    };

	function delete_width_height( $image, $attachment_id, $size, $icon ) {

		$image[1] = '';
		$image[2] = '';

		return $image;
	}


	function give_dequeue_plugin_css() {
		wp_dequeue_style( 'dt-main' );
//		wp_dequeue_style( 'fullcalendar_public_style' );
		wp_dequeue_style( 'dt-web-fonts' );
		wp_dequeue_style( 'dt-awsome-fonts' );
		wp_dequeue_style( 'dt-fontello' );
		wp_dequeue_style( 'style' );
		wp_dequeue_style( 'bsf-Defaults' );
		wp_dequeue_style( 'dt-custom.less' );
		wp_dequeue_style( 'dt-main.less' );
		wp_dequeue_style( 'dt-media.less' );
	}

	function my_site_WI_dequeue_script() {
		wp_dequeue_script( 'dt-main' ); //If you're using disqus, etc.
		wp_dequeue_script( 'jquery_ui' ); //jQuery UI, no thanks!
	}

	function get_assets_json( $key ) {
		global $themeUri;

		$assets = file_get_contents( "$themeUri/mastak/src/assets.json" );
		if ( $assets ) {
			$assetsJson = json_decode( $assets, true );
			if ( $assetsJson ) {
				$scriptsData = array( "common" => $assetsJson["common"] );
				if ( isset( $assetsJson[ $key ] ) ) {
					$scriptsData[ $key ] = $assetsJson[ $key ];
				}

				return $scriptsData;
			}
		}

		return null;
	}

	function add_yandex_map() {
		wp_enqueue_script( 'yandex-maps', "https://api-maps.yandex.ru/2.1/?lang=ru_RU", false, null, true );
		wp_add_inline_script( 'yandex-maps', '
		        function init() {
                    var multiRoute1 = new ymaps.multiRouter.MultiRoute({
                        referencePoints: [
                            [55.6211, 27.0952],
                            \'Н2100, Слабодка, Витебская область, Браславский район\',
                            \'поселок Красногорка, Беларусь, Витебская область\',
                        ],
                        params: {
                            results: 2
                        }
                    }, {
                        boundsAutoApply: true
                    });
                    
                    var multiRoute2 = new ymaps.multiRouter.MultiRoute({
                        referencePoints: [
                            [55.6211, 27.0952],
                            \'Н2100, Слабодка, Витебская область, Браславский район\',
                            \'поселок Красногорка, Беларусь, Витебская область\',
                        ],
                        params: {
                            results: 2
                        }
                    }, {
                        boundsAutoApply: true
                    });
        
                    var topMap = new ymaps.Map(\'top-map\', {
                        center: [55.7516, 27.1373],
                        zoom: 7
                    });
                    
                    var smallMap = new ymaps.Map(\'small-map\', {
                        center: [55.7516, 27.1373],
                        zoom: 7
                    });
                    topMap.geoObjects.add(multiRoute1);
                    smallMap.geoObjects.add(multiRoute2);
                }

                ymaps.ready(init);
		
		' );

		$yandex_css = "#top-map, #small-map {
                            min-height: 330px;
                        }";

		wp_add_inline_style( 'house', $yandex_css );
	}