<?php

    if (!defined('ABSPATH')) {
        exit;
    }

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <title><?= presscore_blog_title(); ?></title>
    <meta name="keywords" content="<?= mastak_seo_meta_title(); ?>"/>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head(); ?>

    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KDZSH92');</script>
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
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
        .modal-online-video{
            display : none;
            position: fixed;
            width : 100%;
            height : 100%;
            background-color : rgba(0,0,0,0.7);
            align-items : center;
            justify-content : center;
            z-index: 1000;
        }
        .modal-online-video__container{
            width : 100%;
            height : 100%;
            position: absolute;
            display : flex;
            justify-content : center;
            align-items : center;
        }
        .modal-online-video__video{
            background-color : #fff;
            padding: .5rem;
            max-width: 320px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.8);
            position: relative;
            border-radius: .25rem;
        }

        .modal-online-video__close{
            position: absolute;
            right: 1rem;
            top : -1rem;
            width : 2rem;
            height: 2rem;
            padding: .5rem;
            border-radius: 100%;
            background : #fff url("/wp-content/themes/krasnagorka/mastak/src/icons/cancel-music.svg") no-repeat;
            background-size: 50%;
            background-position: center center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }

        .modal-online-video__spinner{
            width : 64px;
            height : 64px;
            background: url('/wp-content/themes/krasnagorka/mastak/src/icons/loading.svg') no-repeat;
            background-size: 50%;
            background-position: center center;
            animation: rotateInf 1s infinite;
        }

        @keyframes rotateInf {
            0%{transform: rotate(0)}
            100%{transform: rotate(360deg)}
        }

        @media (min-width: 768px){
            .modal-online-video__video{
                padding: 1rem;
                border-radius: .5rem;
                max-width: 720px;
            }

            .modal-online-video__close{
                right: -1rem;
            }
        }
    </style>
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
<noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=1020781118034010&ev=PageView&noscript=1"/>
</noscript>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDZSH92"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="modal-online-video">
    <div class="modal-online-video__container">
        <div class="modal-online-video__video">
            <div class="modal-online-video__spinner"></div>
        </div>
    </div>
</div>