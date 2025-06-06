<?php

if (!defined('ABSPATH')) {
	exit;
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title>
		<?= wp_title(); ?>
	</title>
	<meta name="keywords" content="<?= mastak_seo_meta_title(); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	 
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/lwc/frontend/fonts/AvenirNextCyr/fonts.css" rel="stylesheet"/>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php wp_head(); ?>
	<style>
		.modal-online-video {
			display: none;
			position: fixed;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			align-items: center;
			justify-content: center;
			z-index: 1000;
		}

		.modal-online-video__container {
			width: 100%;
			height: 100%;
			position: absolute;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.modal-online-video__video {
			max-width: 100%;
			position: relative;
		}

		.modal-online-video__video img {
			width: 100%;
			display: block;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9);
		}

		.modal-online-video__close {
			position: absolute;
			right: 1rem;
			top: -1rem;
			width: 2rem;
			height: 2rem;
			padding: .5rem;
			border-radius: 100%;
			background: #fff url("/wp-content/themes/krasnagorka/mastak/src/icons/cancel-music.svg") center center no-repeat;
			background-size: 50%;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.9);
			cursor: pointer;
		}

		.modal-online-video__spinner {
			width: 64px;
			height: 64px;
			margin: 0 auto;
			border-radius: 100%;
			background: #fff url('https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/src/icons/loading.svg') no-repeat;
			background-size: 50%;
			background-position: center center;
			animation: rotateInf 1s infinite;
		}

		@keyframes rotateInf {
			0% {
				transform: rotate(0)
			}

			100% {
				transform: rotate(360deg)
			}
		}

		@media (min-width : 768px) {
			.modal-online-video__close {
				right: -1rem;
			}
		}

		@media (min-width : 1024px) {
			.modal-online-video__video {
				width: 1024px;
			}
		}

		.kg-loader {
			position: fixed;
			z-index: 999999999999;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: #f7f7f7;
		}

		.kg-loader__img {
			width: 100px;
			display: inline-block;
			animation: kgSpinner 2s ease-out infinite;
		}

		@keyframes kgSpinner {
			0%.100% {
				transform: scale(1)
			}

			50% {
				transform: scale(1.25)
			}
		}

		.main-slider__slide-content-button {
			text-align: center;
		}

		.booking-dogovor {
			color: #1498c6;
			text-decoration: none;
		}

		.booking-dogovor:hover {
			text-decoration: underline;
		}

		.kg-error-message {
			position: fixed;
			top: 100px;
			left: 0;
			width: 100%;
			display: flex;
			justify-content: center;
			z-index: 9999999;
		}

		.kg-error-message p {
			padding: .5rem 1rem;
			max-width: calc(100% - 50px);
			background-color: #d0021b;
			color: #fff;
			border-radius: 6px;
			box-shadow: 0 0px 32px 0px rgba(0, 0, 0, .75);
			font-size: 14px;
			font-weight: bold;
		}

		.menu-bottom__sunny {
			display: none;
		}

		.menu-bottom__sunny-icon {
			margin-left: 1rem;
		}

		@media (min-width : 768px) {
			.menu-bottom__sunny {
				display: block;
			}

			.menu-bottom__sunny-icon {
				margin-left: 0;
			}
		}

		input,
		button,
		textarea {
			-webkit-appearance: none !important;
			-moz-appearance: none !important;
			appearance: none !important;
			border-radius: 6px;
			border: 1px solid #aaaaaa;
		}

		#footer-submit-form {
			flex: 1 0 100%;
		}

		.contacts-form__item:last-child {
			flex-wrap: wrap;
		}

		.contacts-form__item>p {
			width: 100%;
		}

		.footer-top span.wpcf7-not-valid-tip {
			color: #d0021b;
		}

		.footer-top div.wpcf7-response-output {
			color: #d0021b;
		}

		.footer-top div.wpcf7-mail-sent-ok {
			color: #039e24;
		}

		@media (max-width: 568px) {
			.opportunity__title {
				padding-right: 36px;
			}
		}

		.prices__name,
		.prices__table {
			text-align: initial !important;
		}

		.gm-style-iw-d {
			padding: 0 8px 8px 0;
		}

		.our-house__price {
			position: absolute;
			background: linear-gradient(-45deg, #fff, transparent);
			bottom: 0;
			width: 100%;
			padding-right: 2rem;
			height: 42px;
			color: #d0021b;
			font-size: 16px;
			text-transform: uppercase;
			display: flex;
			align-items: center;
			font-weight: 700;
			justify-content: flex-end;
		}

		@media(min-width:768px) {
			.our-house__price {
				margin-bottom: 28px;
			}
		}

		.our-house__price::after {
			content: attr(data-currency);
			text-transform: uppercase;
			margin-left: .25rem;
			font-weight: 700;
		}
	</style>

    <style>
        .css-focused-link, .css-focused-link:focus, .css-focused-link:visited {
            color: #1498c6;
        }
    </style>

	<style>
		.added-info-price{
			margin-top:8px;
			margin-bottom: 16px;
			color: #7d8798;
			text-align: center;
    		font-size: 13px;
		}
		.added-info-price a{
			color: #23C4FC;
		}

		@media (min-width:768px) {
			.added-info-price{
				margin-top:4px;
				margin-bottom: 0;
			}
		}

		.added-info-price_first{
			margin-top: 16px;
			text-align: center;
		}

		@media (min-width:768px) {
			.added-info-price_first{
				text-align: initial;
			}
		}

		.added-info-price__star{
			color: #d0021b;
			margin-right: 4px;
		}

		.big-text a{
			color: #1498c6;
			display: inline-block;
			transition: color .4s ease-in;
		}

		.big-text a:hover{
			color: #00bdff;
		}

		.big-text a:focus{
			color: #1498c6;
		}

		.big-text img {
			display: block;
			width:100%;
			margin: 1rem 0;
		}
		
	</style>

	<!-- Calendar Delimeter Start-->
	<style>

		.fc-day{
			overflow: hidden;
			position: relative;
		}

		.date-delimiter {
			width: 100%;
			height: 100%;
			position: absolute;
		}

		.date-delimiter_to::before {
			content: 'выезд';
			position: absolute;
			text-transform: uppercase;
			font-size: 6px;
			line-height: 1;
			color: #929090;
			top: 0px;
			left: 0;
		}

		.date-delimiter_from::before {
			content: 'заезд';
			position: absolute;
			text-transform: uppercase;
			font-size: 6px;
			line-height: 1;
			color: #929090;
			bottom: 0;
			right: 0;
		}

		.date-delimiter__line {
			position: absolute;
			height: 50%;
			width: 1px;
			background: #d0d0d0;
			bottom: 25%;
			left: 50%;
		}
	</style>
	<!-- Calendar Delimeter End-->

	<script type="text/javascript">
		//Facebook Pixel Code

		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1020781118034010');
		fbq('track', 'PageView');
	</script>

    <?php if(is_post_type_archive( 'house' )) :?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org/",
                "@type": "Product",
                "name": "Дом на браславских озерах",
                "image": [ “https://krasnagorka.by/wp-content/uploads/2022/12/nashi-doma-m.jpeg"
                ],
                "description": "В Вашем распоряжении мангальная зона, катамараны, настольный теннис, бильярд, спортивные площадки и много других развлечений, и, конечно, пляж и чистейшее озеро",
                "offers": {
                    "@type": "AggregateOffer",
                    "offerCount": "8",
                    "lowPrice": "28.00",
                    "highPrice": "40.00",
                    "priceCurrency": "BYN"
                }
            }
        </script>
    <?php endif;?>

</head>
<?php $bg_gray =
	(is_page_template("template-mastak-prices.php")
		or is_page_template("template-mastak-booking.php")
		or is_page_template("template-mastak-map.php")
		or is_page_template("template-page-posts.php"))
	? "b-bgc-wrapper"
	: is_singular('event') ? "b-bgc-wrapper" :
	is_post_type_archive('event') ? "b-bgc-wrapper" : "";
?>

<body <?php
		body_class($bg_gray);
		?>>

	<div id="kg-loader" class="kg-loader">
		<img src="/wp-content/themes/krasnagorka/assets/images/<?= wp_is_mobile() ? "logoKG-xs.png"
																	: "logoKG.png";
																?>" alt="spinner" class="kg-loader__img">
	</div>
	<div class="modal-online-video">
		<div class="modal-online-video__container">
			<div class="modal-online-video__video">
				
			</div>
		</div>
	</div>