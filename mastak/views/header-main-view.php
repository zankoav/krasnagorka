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

    $main_slider       = get_option('mastak_home_appearance_options')['main_slider'];
    $main_slider_delay = get_option('mastak_home_appearance_options')['main_slider_delay'];
    $footer_logo_id    = $options['footer_logo_id'];

?>

<header class="header-top">
    <nav class="menu-top b-container">
        <div class="menu-top__left menu-main">
            <img src="<?= CORE_PATH; ?>assets/icons/menu-icon.svg" class="menu-main__button" alt="menu-button">
            <div class="menu-main__wrapper">
                <div class="menu-main__header">
                    <p class="menu-main__title">Меню</p>
                    <img src="<?= CORE_PATH; ?>assets/icons/menu-close.svg" alt="button-close"
                         class="menu-main__button-close">
                </div>
                <div class="menu-main__scroll-content">
                    <div class="menu-main__scroll-content-wrapper">
                        <?php mastak_nav_menu(); ?>
                        <?php if ($video): ?>
                            <a href="#" class="online-video online-video--menu">
                                <img src="<?= CORE_PATH; ?>assets/icons/online-video-gray.svg" alt="online-video"
                                     class="online-video__icon">
                                <span class="online-video__title">смотреть ONLINE</span>
                            </a>
                        <?php endif; ?>
                        <div class="menu-main__currency currency">
                            <label class="currency__label currency__label--gray">Выберите <br> валюту</label>
                            <select name="currency" class="currency__select--hidden">
                                <option name="<?= KGCookie::BYN; ?>"
                                        value="1" <?= $currency_name === KGCookie::BYN ? 'selected' : ''; ?>>BYN
                                </option>
                                <option name="<?= KGCookie::RUS; ?>"
                                        value="<?= ls_cb_get_rub_rate(); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                                    RUS
                                </option>
                                <option name="<?= KGCookie::USD; ?>"
                                        value="<?= ls_cb_get_usd_rate(); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                                    USD
                                </option>
                                <option name="<?= KGCookie::EUR; ?>"
                                        value="<?= ls_cb_get_eur_rate(); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
                                    EUR
                                </option>
                            </select>
                            <div class="currency__view">
                                <div data-currency="<?= $currency_name; ?>"
                                     class="currency__item currency__item--gray currency__item--selected">
                                    <img src="<?= CORE_PATH; ?>assets/icons/currencies/<?= $currency_name; ?>.svg"
                                         class="currency__item-flag" alt="flag">
                                    <span class="currency__item-type"><?= $currency_name; ?></span>
                                </div>
                                <ul class="currency__list">
                                    <li data-currency="<?= KGCookie::BYN; ?>"
                                        class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/byn.svg"
                                             class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">BYN</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::RUS; ?>"
                                        class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/rur.svg"
                                             class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">RUS</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::USD; ?>"
                                        class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/usd.svg"
                                             class="currency__item-flag" alt="flag">
                                        <span class="currency__item-type">USD</span>
                                    </li>
                                    <li data-currency="<?= KGCookie::EUR; ?>"
                                        class="currency__item currency__item--gray currency__item--list">
                                        <img src="<?= CORE_PATH; ?>assets/icons/currencies/eur.svg"
                                             class="currency__item-flag" alt="flag">
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
            <a href="/" class="logo">
                <?php
                    $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo');
                ?>
                <img src="<?= $footer_logo_src[0]; ?>" alt="logo" class="logo__icon">
            </a>
            <?php if ($video): ?>
                <a href="#" class="online-video">
                    <img src="<?= CORE_PATH; ?>assets/icons/online-video.svg" alt="online-video"
                         class="online-video__icon">
                    <span class="online-video__title">смотреть ONLINE</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="menu-top__right contacts-menu">
            <img src="<?= CORE_PATH; ?>assets/icons/contacts-icon.svg" alt="button-phone"
                 class="contacts-menu__button contacts-menu__button--phone">
            <div class="contacts-popup">
                <div class="contacts-popup__wrapper">
                    <div class="contacts-popup__phones phone-list phone-list--messanger">
                        <div class="phone-item ">
                            <img src="<?= CORE_PATH; ?>assets/icons/a1.png" alt="icon-a1"
                                 class="phone-item__icon phone-item__icon--velcome">
                            <a href="tel: <?= $a1; ?>" class="phone-item__phone-number phone-item__phone-number_velcom"><?= $a1; ?></a>
                            <img src="<?= CORE_PATH; ?>assets/icons/social/viber.svg" alt="icon-viber"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--viber">
                            <img src="<?= CORE_PATH; ?>assets/icons/social/whatsapp.svg" alt="icon-whatsapp"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--whatsapp">
                            <a href="<?=$telegram;?>" target="_blank">
                                 <img src="<?= CORE_PATH; ?>assets/icons/social/telegram.svg" alt="icon-telegram"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--telegram">
                            </a>
                        </div>
                    </div>
                    <div class="contacts-popup__phones phone-list">
                        <div class="phone-item">
                            <img src="<?= CORE_PATH; ?>assets/icons/mts.svg" alt="icon-mts"
                                 class="phone-item__icon phone-item__icon--mts">
                            <a href="tel: <?= $mts; ?>" class="phone-item__phone-number phone-item__phone-number_mts"><?= $mts; ?></a>
                        </div>
                        <?php if(isset($life)):?>
                            <div class="phone-item">
                                <img src="<?= CORE_PATH; ?>assets/icons/life.svg" alt="icon-life"
                                    class="phone-item__icon phone-item__icon--life">
                                <a href="tel: <?= $life; ?>" class="phone-item__phone-number phone-item__phone-number_life"><?= $life; ?></a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="contacts-popup__email">
                        <img src="<?= CORE_PATH; ?>assets/icons/envelope.svg" alt="icon-envelope"
                             class="contacts-popup__icon contacts-popup__icon--envelope">
                        <a href="mailto:<?= $email; ?>" class="contacts-popup__email-text"><?= $email; ?></a>
                    </div>
                    <div class="contacts-popup__working-time">
                        <img src="<?= CORE_PATH; ?>assets/icons/clock.svg" alt="icon-clock"
                             class="contacts-popup__icon contacts-popup__icon--clock">
                        <span class="contacts-popup__working-time-text"><?= $time; ?></span>
                    </div>
                    <div class="contacts-popup__working-time">
                        <?php if(empty($weekend)):
                            $weekend = 'без выходных';
                            ?>
                        <?php else: ?>
                            <img src="<?= CORE_PATH; ?>assets/icons/clock.svg" alt="icon-clock"
                                 class="contacts-popup__icon contacts-popup__icon--clock">
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

                        <?php if ($m_slide["use_video"] and !wp_is_mobile()):
                            $video_url = esc_url($m_slide["slide_video"]); ?>
                            <div class="main-slider__slide-img-wrapper">
                                <video width="400" height="320" autoplay loop muted>
                                    <source src="<?= $video_url; ?>"
                                            type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                    Тег video не поддерживается вашим браузером.
                                </video>
                            </div>
                        <?php else :?>
                            <div class="main-slider__slide-img-wrapper">
                                <img class="object-fit-img"
                                     src="<?= wp_get_attachment_image_url( $m_slide["slide_image_id"], $image_size ) ?>"
                                     srcset="<?= wp_get_attachment_image_srcset(  $m_slide["slide_image_id"], $image_size ) ?>"
                                     sizes="<?= wp_get_attachment_image_sizes(  $m_slide["slide_image_id"], $image_size ) ?>">
                            </div>
                        <?php endif; ?>
                        <div class="main-slider__slide-content">
                            <?php if ($isFirst):
                                $isFirst = false;
                                ?>
                                <h1 class="main-slider__slide-content-title"><?= $m_slide["slide_title"]; ?></h1>
                            <?php else: ?>
                                <p class="main-slider__slide-content-title"><?= $m_slide["slide_title"]; ?></p>
                            <?php endif; ?>
                            <p class="main-slider__slide-content-sub-title"><?= $m_slide["slide_description"]; ?></p>
                            <?php if (!empty($m_slide["slide_button_url"])) : ?>
                                <a href="<?= $m_slide["slide_button_url"]; ?>"
                                   target="<?= $m_slide["slide_button_open_type"] ? '_blank' : '_self'; ?>"
                                   class="main-slider__slide-content-button ">
                                    <?= $m_slide["slide_button_title"]; ?>
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

    <div class="menu-bottom">
        <div class="b-container menu-bottom__wrapper">
            <div class="menu-bottom__left">
                <div class="menu-bottom__currency currency">
                    <label class="currency__label currency__label--white">Выберите <br> валюту</label>
                    <select name="currency" class="currency__select--hidden">
                        <option name="<?= KGCookie::BYN; ?>"
                                value="1" <?= $currency_name === KGCookie::BYN ? 'selected' : ''; ?>>BYN
                        </option>
                        <option name="<?= KGCookie::RUS; ?>"
                                value="<?= ls_cb_get_rub_rate(); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                            RUS
                        </option>
                        <option name="<?= KGCookie::USD; ?>"
                                value="<?= ls_cb_get_usd_rate(); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                            USD
                        </option>
                        <option name="<?= KGCookie::EUR; ?>"
                                value="<?= ls_cb_get_eur_rate(); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
                            EUR
                        </option>
                    </select>
                    <div class="currency__view">
                        <div data-currency="<?= $currency_name; ?>"
                             class="currency__item currency__item--white currency__item--selected">
                            <img src="<?= CORE_PATH ?>assets/icons/currencies/<?= $currency_name; ?>.svg"
                                 class="currency__item-flag"
                                 alt="flag">
                            <span class="currency__item-type"><?= $currency_name; ?></span>
                        </div>
                        <ul class="currency__list currency__list--white">
                            <li data-currency="<?= KGCookie::BYN; ?>"
                                class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/byn.svg"
                                     class="currency__item-flag"
                                     alt="flag">
                                <span class="currency__item-type">BYN</span>
                            </li>
                            <li data-currency="<?= KGCookie::RUS; ?>"
                                class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/rur.svg"
                                     class="currency__item-flag"
                                     alt="flag">
                                <span class="currency__item-type">RUS</span>
                            </li>
                            <li data-currency="<?= KGCookie::USD; ?>"
                                class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/usd.svg"
                                     class="currency__item-flag"
                                     alt="flag">
                                <span class="currency__item-type">USD</span>
                            </li>
                            <li data-currency="<?= KGCookie::EUR; ?>"
                                class="currency__item currency__item--list">
                                <img src="<?= CORE_PATH ?>assets/icons/currencies/eur.svg"
                                     class="currency__item-flag"
                                     alt="flag">
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
                                <span><?= date('j'); ?></span><?= get_current_month_rus(); ?></div>
                        </div>
                        <div style="display:none" class="menu-bottom__details-sunny">
                            <img class="menu-bottom__sunny-icon" src="<?= $weather[1]["icon"]; ?>"
                                 alt="sunny">
                            <div class="menu-bottom__sunny"><?= $weather[1]["text"]; ?></div>
                        </div>
                        <p style="display:none" class="menu-bottom__degrees"><?= $weather[1]["temp"]; ?>
                            <span>&deg;C</span>
                        </p>
                    </div>
                    <ul style="display:none" class="menu-bottom__days">
                        <li class="menu-bottom__day">
                            <p class="menu-bottom__day-text"><?= $weather[2]["weekday"]; ?></p>
                            <img src="<?= $weather[2]["icon"]; ?>" alt="weather"
                                 class="menu-bottom__day-icon">
                        </li>
                        <li class="menu-bottom__day">
                            <p class="menu-bottom__day-text"><?= $weather[3]["weekday"]; ?></p>
                            <img src="<?= $weather[3]["icon"]; ?>" alt="weather"
                                 class="menu-bottom__day-icon">
                        </li>
                        <li class="menu-bottom__day">
                            <p class="menu-bottom__day-text"><?= $weather[4]["weekday"]; ?></p>
                            <img src="<?= $weather[4]["icon"]; ?>" alt="weather"
                                 class="menu-bottom__day-icon">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>