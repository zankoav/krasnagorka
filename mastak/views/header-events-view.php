<?php

$options = get_option('mastak_theme_options');
$email   = $options['mastak_theme_options_email'];
$life    = $options['mastak_theme_options_life'];
$a1  = $options['mastak_theme_options_a1'];
$mts     = $options['mastak_theme_options_mts'];
$telegram       = $options['mastak_theme_options_telegram'];
$weekend = $options['mastak_theme_options_weekend'];
$time    = $options['mastak_theme_options_time'];
$video   = $options['mastak_theme_options_video'];
$weather = get_weather();
global $kgCooke;
$currency_name = $kgCooke->getCurrnecy()["currency_selected"];

$main_slider       = get_option('mastak_event_appearance_options')['special_events'];
$main_slider_delay = get_option('mastak_event_appearance_options')['main_slider_delay'];

?>

<header class="header-second">
    <nav class="menu-top b-container">
        <div class="menu-top__left menu-main">
            <img src="<?= CORE_PATH; ?>assets/icons/menu-icon.svg" class="menu-main__button" alt="menu-button">
            <div class="menu-main__wrapper">
                <div class="menu-main__header">
                    <p class="menu-main__title">Меню</p>
                    <img src="<?= CORE_PATH; ?>assets/icons/menu-close.svg" alt="button-close" class="menu-main__button-close">
                </div>
                <div class="menu-main__scroll-content">
                    <div class="menu-main__scroll-content-wrapper">
                        <?php mastak_nav_menu(); ?>

                        <?php if ($video): ?>
                        <a href="https://public.ivideon.com/embed/v3/?server=100-Zkn8nBIwRPePMTeUfZtRVW&camera=0&width=&height=&lang=ru" target="_blank"
                           class="online-video online-video--menu">
                            <img src="<?= CORE_PATH; ?>assets/icons/online-video-gray.svg"
                                 alt="online-video"
                                 class="online-video__icon">
                            <span class="online-video__title">смотреть ONLINE</span>
                        </a>
                        <?php endif; ?>
                        <div class="menu-main__currency currency">
                            <label class="currency__label currency__label--gray">Выберите <br>
                                валюту</label>
                            <select name="currency" class="currency__select--hidden">
                                <option name="<?= KGCookie::BYN; ?>" value="1" <?= $currency_name === KGCookie::BYN ? 'selected' : ''; ?>>
                                    BYN
                                </option>
                                <option name="<?= KGCookie::RUS; ?>" value="<?= ls_cb_get_rub_rate(); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                                    RUS
                                </option>
                                <option name="<?= KGCookie::USD; ?>" value="<?= ls_cb_get_usd_rate(); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                                    USD
                                </option>
                                <option name="<?= KGCookie::EUR; ?>" value="<?= ls_cb_get_eur_rate(); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
                                    EUR
                                </option>
                            </select>
                            <div class="currency__view">
                                <div data-currency="<?= $currency_name; ?>" class="currency__item currency__item--gray currency__item--selected">
                                    <img src="<?= CORE_PATH; ?>assets/icons/currencies/<?= $currency_name; ?>.svg" class="currency__item-flag" alt="flag">
                                    <span class="currency__item-type"><?= $currency_name; ?></span>
                                </div>
                                <ul class="currency__list">
                                    <li data-currency="<?= KGCookie::BYN; ?>" class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/byn.svg" class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">BYN</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::RUS; ?>" class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/rur.svg" class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">RUS</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::USD; ?>" class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/usd.svg" class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">USD</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::EUR; ?>" class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/eur.svg" class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">EUR</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-main__glass"></div>
        </div>
        <div class="menu-top__center">
            <a href="/"
               class="logo">
                <img src="<?= CORE_PATH; ?>assets/icons/logo.png"
                     alt="logo"
                     class="logo__icon">
            </a>
            <?php if ($video && !wp_is_mobile()): ?>
            <a href="https://public.ivideon.com/embed/v3/?server=100-Zkn8nBIwRPePMTeUfZtRVW&camera=0&width=&height=&lang=ru"
                target="_blank" class="online-video">
                <img src="<?= CORE_PATH; ?>assets/icons/online-video.svg"
                     alt="online-video"
                     class="online-video__icon">
                <span class="online-video__title">смотреть ONLINE</span>
            </a>
            <?php endif; ?>
        </div>
        <div class="menu-top__right contacts-menu">
            <img src="<?= CORE_PATH; ?>assets/icons/contacts-icon.svg" alt="button-phone" class="contacts-menu__button contacts-menu__button--phone">

            <div class="contacts-popup">
                <div class="contacts-popup__wrapper">
                    <div class="contacts-popup__phones phone-list phone-list--messanger">
                        <div class="phone-item ">
                            <img src="<?= CORE_PATH; ?>assets/icons/a1.png" alt="icon-a1" class="phone-item__icon phone-item__icon--velcome">
                            <a href="tel: <?= $a1; ?>" class="phone-item__phone-number phone-item__phone-number_velcom"><?= $a1; ?></a>
                            <img src="<?= CORE_PATH; ?>assets/icons/social/viber.svg" alt="icon-viber" class="phone-item__icon phone-item__icon--small phone-item__icon--viber">
                            <img src="<?= CORE_PATH; ?>assets/icons/social/whatsapp.svg" alt="icon-whatsapp" class="phone-item__icon phone-item__icon--small phone-item__icon--whatsapp">
                            <a href="<?= $telegram; ?>" target="_blank">
                                <img src="<?= CORE_PATH; ?>assets/icons/social/telegram.svg" alt="icon-telegram" class="phone-item__icon phone-item__icon--small phone-item__icon--telegram">
                            </a>
                        </div>
                    </div>
                    <div class="contacts-popup__phones phone-list">
                        <div class="phone-item">
                            <img src="<?= CORE_PATH; ?>assets/icons/mts.svg" alt="icon-mts" class="phone-item__icon phone-item__icon--mts">
                            <a href="tel: <?= $mts; ?>" class="phone-item__phone-number phone-item__phone-number_mts"><?= $mts; ?></a>
                        </div>
                        <?php if (isset($life)) : ?>
                            <div class="phone-item">
                                <img src="<?= CORE_PATH; ?>assets/icons/life.svg" alt="icon-life" class="phone-item__icon phone-item__icon--life">
                                <a href="tel: <?= $life; ?>" class="phone-item__phone-number phone-item__phone-number_life"><?= $life; ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="contacts-popup__email">
                        <img src="<?= CORE_PATH; ?>assets/icons/envelope.svg" alt="icon-envelope" class="contacts-popup__icon contacts-popup__icon--envelope">
                        <a href="mailto:<?= $email; ?>" class="contacts-popup__email-text"><?= $email; ?></a>
                    </div>
                    <div class="contacts-popup__working-time">
                        <img src="<?= CORE_PATH; ?>assets/icons/clock.svg" alt="icon-clock" class="contacts-popup__icon contacts-popup__icon--clock">
                        <span class="contacts-popup__working-time-text"><?= $time; ?></span>
                    </div>
                    <div class="contacts-popup__working-time">
                        <?php if (empty($weekend)) :
                            $weekend = 'без выходных';
                        ?>
                        <?php else : ?>
                            <img src="<?= CORE_PATH; ?>assets/icons/clock.svg" alt="icon-clock" class="contacts-popup__icon contacts-popup__icon--clock">
                        <?php endif; ?>
                        <span class="contacts-popup__working-time-after-text"><?= $weekend; ?></span>
                    </div>
                </div>
            </div>

        </div>
    </nav>
    <div class="swiper-container main-slider">
        <div class="swiper-wrapper main-slider__wrapper">
            <?php
            $isFirst = true;
            $image_size = wp_is_mobile() ? 'header_iphone_5' : 'header_laptop_hd';

            foreach ($main_slider as $m_slide) : ?>
                <div class="swiper-slide main-slider__slide" data-swiper-autoplay="<?= $main_slider_delay; ?>">

                    <?php if ($m_slide["use_video"] and !wp_is_mobile()) :
                        $video_url = esc_url($m_slide["slide_video"]); ?>
                        <div class="main-slider__slide-img-wrapper">
                            <video width="400" height="320" autoplay loop muted>
                                <source src="<?= $video_url; ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                Тег video не поддерживается вашим браузером.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="main-slider__slide-img-wrapper">
                            <img class="object-fit-img" src="<?= wp_get_attachment_image_url($m_slide["item_banner"], $image_size) ?>" srcset="<?= wp_get_attachment_image_srcset($m_slide["item_banner_id"], $image_size) ?>" sizes="<?= wp_get_attachment_image_sizes($m_slide["item_banner"], $image_size) ?>">
                        </div>
                    <?php endif; ?>
                    <div class="main-slider__slide-content">
                        <?php if ($isFirst) :
                            $isFirst = false;
                        ?>
                            <h1 class="main-slider__slide-content-title"><?= $m_slide["item_name"]; ?></h1>
                        <?php else : ?>
                            <p class="main-slider__slide-content-title"><?= $m_slide["item_name"]; ?></p>
                        <?php endif; ?>
                        <p class="main-slider__slide-content-sub-title"><?= $m_slide["item_subtitle"]; ?></p>
                        <?php if (!empty($m_slide["button_url"])) : ?>
                            <a href="<?= $m_slide["button_url"]; ?>"  class="main-slider__slide-content-button ">
                                <?= $m_slide["button_text"]; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add Arrows -->
        <div class="main-slider__next-prev">
            <div class="b-container main-slider__next-prev-wrapper">
                <div class="swiper-button-next main-slider__button-next"></div>
                <div class="swiper-button-prev main-slider__button-prev"></div>
            </div>
        </div>
        <div class="swiper-pagination main-slider__pagination"></div>

    </div>



    <?php if (wp_is_mobile()) : ?>
        <?php do_action("mastak_header_small_view_title"); ?>
    <?php endif; ?>
    
    <div class="menu-bottom">
        <div class="b-container menu-bottom__wrapper">
            <div class="menu-bottom__left">
                <div class="menu-bottom__currency currency">
                    <label class="currency__label currency__label--white">Выберите <br>
                        валюту</label>
                    <select name="currency" class="currency__select--hidden">
                        <option name="<?= KGCookie::BYN; ?>" value="1" <?= $currency_name === KGCookie::BYN ? 'selected' : ''; ?>>BYN
                        </option>
                        <option name="<?= KGCookie::RUS; ?>" value="<?= ls_cb_get_rub_rate(); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                            RUS
                        </option>
                        <option name="<?= KGCookie::USD; ?>" value="<?= ls_cb_get_usd_rate(); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                            USD
                        </option>
                        <option name="<?= KGCookie::EUR; ?>" value="<?= ls_cb_get_eur_rate(); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
                            EUR
                        </option>
                    </select>
                    <div class="currency__view">
                        <div data-currency="<?= $currency_name; ?>" class="currency__item currency__item--white currency__item--selected">
                            <img src="<?= CORE_PATH ?>assets/icons/currencies/<?= $currency_name; ?>.svg" class="currency__item-flag" alt="flag">
                            <span class="currency__item-type"><?= $currency_name; ?></span>
                        </div>
                        <ul class="currency__list currency__list--white">
                            <li data-currency="<?= KGCookie::BYN; ?>" class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/byn.svg" class="currency__item-flag" alt="flag">
                                <span class="currency__item-type">BYN</span>
                            </li>
                            <li data-currency="<?= KGCookie::RUS; ?>" class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/rur.svg" class="currency__item-flag" alt="flag">
                                <span class="currency__item-type">RUS</span>
                            </li>
                            <li data-currency="<?= KGCookie::USD; ?>" class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/usd.svg" class="currency__item-flag" alt="flag">
                                <span class="currency__item-type">USD</span>
                            </li>
                            <li data-currency="<?= KGCookie::EUR; ?>" class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/eur.svg" class="currency__item-flag" alt="flag">
                                <span class="currency__item-type">EUR</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu-bottom__right">
                <div class="menu-bottom__right--wrapper">
                    <div class="menu-bottom__details">
                        <div class="menu-bottom__details-place">
                            <p class="menu-bottom__place">Красногорка</p>
                            <div class="menu-bottom__date">
                                <span><?= date('j'); ?></span><?= get_current_month_rus(); ?>
                            </div>
                        </div>
                        <div class="menu-bottom__details-sunny">
                            <img class="menu-bottom__sunny-icon" src="<?= $weather[0]["icon"]; ?>" alt="sunny">
                            <div class="menu-bottom__sunny"><?= $weather[0]["text"]; ?></div>
                        </div>
                        <p class="menu-bottom__degrees"><?= $weather[0]["temp"]; ?>
                        </p>
                    </div>
                    <?php if (!wp_is_mobile()) : ?>
                        <ul class="menu-bottom__days">
                            <li class="menu-bottom__day">
                                <p class="menu-bottom__day-text"><?= $weather[1]["weekday"]; ?></p>
                                <img src="<?= $weather[1]["icon"]; ?>" alt="weather" class="menu-bottom__day-icon">
                            </li>
                            <li class="menu-bottom__day">
                                <p class="menu-bottom__day-text"><?= $weather[2]["weekday"]; ?></p>
                                <img src="<?= $weather[2]["icon"]; ?>" alt="weather" class="menu-bottom__day-icon">
                            </li>
                            <li class="menu-bottom__day">
                                <p class="menu-bottom__day-text"><?= $weather[3]["weekday"]; ?></p>
                                <img src="<?= $weather[3]["icon"]; ?>" alt="weather" class="menu-bottom__day-icon">
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="<?= wp_is_mobile() ? '' : 'b-bgc-dark'; ?> b-py-1">
    <div class="b-container">
        <div class="breadcrumbs-wrapper">
            <?php if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
            } ?>
            <?php if ($isBreadcrumbsBannerEnabled) : ?>
                <style>
                    .breadcrumbs {
                        display: none;
                    }

                    .breadcrumbs-wrapper {
                        display: block;
                    }

                    @media (min-width : 768px) {
                        .breadcrumbs {
                            margin-bottom: 1rem;
                            display: block;
                        }
                    }

                    @media (min-width : 1280px) {
                        .breadcrumbs {
                            margin-bottom: 0;
                            max-width: 50%;
                            flex: 1 0 50%;
                            text-overflow: ellipsis;
                            overflow: hidden;
                            white-space: nowrap;
                        }

                        .breadcrumbs-wrapper {
                            justify-content: space-between;
                            display: flex;
                        }
                    }

                    .breadcrumbs-wrapper__link {
                        display: flex;
                        align-items: center;
                        color: #999;
                        transition: color .3s linear;

                        width: 90%;
                        margin-right: -1.5rem;
                        margin-left: auto;
                        padding: 0.75rem 0.5rem;
                        background: #fff;
                        border-bottom-left-radius: 1rem;
                        border-top-left-radius: 1rem;
                        box-shadow: 0 2px 4px 0 rgb(0 0 0 / 25%);
                    }

                    @media (min-width : 1280px) {
                        .breadcrumbs-wrapper__link {
                            flex: 1 0 50%;
                            padding-left: 2rem;
                            max-width: 50%;

                            width: initial;
                            margin-right: initial;
                            margin-left: initial;
                            padding: initial;
                            background: initial;
                            border-bottom-left-radius: initial;
                            border-top-left-radius: initial;
                            box-shadow: initial;
                        }
                    }

                    .breadcrumbs-wrapper__link:hover {
                        color: #7ed321;
                    }

                    .breadcrumbs-wrapper__link-img {
                        flex-shrink: 0;
                        margin-right: 1rem;
                        max-height: 1.5rem;
                        display: inline-block;
                    }

                    @media (min-width : 1280px) {
                        .breadcrumbs-wrapper__link-img {
                            margin-left: auto;
                        }
                    }
                </style>
                <a href="<?= $breadcrumbsBannerLink; ?>" target="<?= $isBreadcrumbsBannerTargetLink; ?>" class="breadcrumbs-wrapper__link" style="animation-delay: <?= $breadcrumbsBannerAnimationDelay; ?>ms;">
                    <img src="<?= empty($breadcrumbsBannerImg) ? "/wp-content/themes/krasnagorka/mastak/assets/icons/marketing/$breadcrumbsBannerImgDefault.svg" : $breadcrumbsBannerImg; ?>" class="breadcrumbs-wrapper__link-img" alt="banner icon">
                    <p class="breadcrumbs-wrapper__link-title"><?= $breadcrumbsBannerText; ?></p>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (wp_is_mobile()) : ?>
    <script>
        (function() {
            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            });

            var date = Date.now();

            function draw(delta) {
                requestAnimationFrame(draw);
                canvas.width = canvas.width;
                var my_gradient = ctx.createLinearGradient(0, 0, 0, canvas.height / 2);
                my_gradient.addColorStop(0, "rgba(80, 157, 159, 0.75)");
                my_gradient.addColorStop(1, "rgba(21, 139, 194, 0.75)");
                ctx.fillStyle = my_gradient;

                var randomLeft = Math.abs(Math.pow(Math.sin(delta / 1000), 2)) * 100;
                var randomRight = Math.abs(Math.pow(Math.sin((delta / 1000) + 10), 2)) * 100;
                var randomLeftConstraint = Math.abs(Math.pow(Math.sin((delta / 1000) + 2), 2)) * 100;
                var randomRightConstraint = Math.abs(Math.pow(Math.sin((delta / 1000) + 1), 2)) * 100;

                ctx.beginPath();
                ctx.moveTo(0, randomLeft);

                // ctx.lineTo(canvas.width, randomRight);
                ctx.bezierCurveTo(canvas.width / 3, randomLeftConstraint, canvas.width / 3 * 2, randomRightConstraint, canvas.width, randomRight);
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.lineTo(0, randomLeft);

                ctx.closePath();
                ctx.fill();
            }
            requestAnimationFrame(draw);
        })();
        <?php endif;  ?>
    </script>
