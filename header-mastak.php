<?php

if (!defined('ABSPATH')) {
	exit;
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?= presscore_blog_title(); ?></title>
	<meta name="keywords" content="<?= mastak_seo_meta_title(); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="preload" as="font" type="font/ttf" crossorigin href="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/src/fonts/AvenirNextCyr-Bold.cb5f2e.ttf" />
	<link rel="preload" as="font" type="font/ttf" crossorigin href="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/src/fonts/AvenirNextCyr-Regular.97b615.ttf" />
	<link rel="preload" as="font" type="font/woff" crossorigin href="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/src/fonts/AvenirNextCyr-UltraLight.decf85.woff" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head(); ?>

	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-KDZSH92');
	</script>
	<!-- Facebook Pixel Code -->
	<script>
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
			background: #fff url('//mastak/src/icons/loading.svg') no-repeat;
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
			box-shadow: 0 0px 32px 0px rgba(0,0,0,.75);
			font-size: 14px;
			font-weight: bold;
		}
	</style>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(37788340, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
        });
    </script>
</head>
<?php $bg_gray =
	(is_page_template("template-mastak-prices.php")
		or is_page_template("template-mastak-booking.php")
		or is_page_template("template-mastak-map.php"))
	? "b-bgc-wrapper"
	: is_singular('event') ? "b-bgc-wrapper" :
	is_post_type_archive('event') ? "b-bgc-wrapper" : "";

?>

<body <?php body_class($bg_gray); ?>>
    <noscript><div><img src="https://mc.yandex.ru/watch/37788340" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
	<div id="kg-loader" class="kg-loader">
		<img src="/wp-content/themes/krasnagorka/assets/images/<?= wp_is_mobile() ? "logoKG-xs.png" : "logoKG.png"; ?>" alt="spinner" class="kg-loader__img">
	</div>
	<noscript>
		<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1020781118034010&ev=PageView&noscript=1" />
	</noscript>
	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDZSH92" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div class="modal-online-video">
		<div class="modal-online-video__container">
			<div class="modal-online-video__video">
				<div class="modal-online-video__spinner"></div>
			</div>
		</div>
	</div>