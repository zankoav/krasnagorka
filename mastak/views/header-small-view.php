<?php

    $options = get_option('mastak_theme_options');
    $email   = $options['mastak_theme_options_email'];
    $life    = $options['mastak_theme_options_life'];
    $velcom  = $options['mastak_theme_options_velcome'];
    $mts     = $options['mastak_theme_options_mts'];
    $weekend = $options['mastak_theme_options_weekend'];
    $time    = $options['mastak_theme_options_time'];
    $video   = $options['mastak_theme_options_video'];
    $weather = get_weather();
    global $kgCooke;
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];
?>

<header class="header-second">
    <nav class="menu-top b-container">
        <div class="menu-top__left menu-main">
            <img src="<?= CORE_PATH; ?>assets/icons/menu-icon.svg" class="menu-main__button"
                 alt="menu-button">
            <div class="menu-main__wrapper">
                <div class="menu-main__header">
                    <p class="menu-main__title">Меню</p>
                    <img src="<?= CORE_PATH; ?>assets/icons/menu-close.svg" alt="button-close"
                         class="menu-main__button-close">
                </div>
                <div class="menu-main__scroll-content">
                    <div class="menu-main__scroll-content-wrapper">
                        <?php mastak_nav_menu(); ?>

                        <?php if (!empty($video)): ?>
                            <a href="<?= $video; ?>" class="online-video online-video--menu" target="_blank">
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
                                        value="<?= get_option('rur_currency'); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                                    RUS
                                </option>
                                <option name="<?= KGCookie::USD; ?>"
                                        value="<?= get_option('usd_currency'); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                                    USD
                                </option>
                                <option name="<?= KGCookie::EUR; ?>"
                                        value="<?= get_option('eur_currency'); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
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
                <img src="<?= CORE_PATH; ?>assets/icons/logo.png" alt="logo" class="logo__icon">
            </a>
            <?php if (!empty($video)): ?>
                <a href="<?= $video; ?>" class="online-video" target="_blank">
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
                            <img src="<?= CORE_PATH; ?>assets/icons/velcome.svg" alt="icon-velcome"
                                 class="phone-item__icon phone-item__icon--velcome">
                            <a href="tel: <?= $velcom; ?>" class="phone-item__phone-number"><?= $velcom; ?></a>
                            <img src="<?= CORE_PATH; ?>assets/icons/social/viber.svg" alt="icon-viber"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--viber">
                            <img src="<?= CORE_PATH; ?>assets/icons/social/whatsapp.svg" alt="icon-whatsapp"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--whatsapp">
                            <img src="<?= CORE_PATH; ?>assets/icons/social/telegram.svg" alt="icon-telegram"
                                 class="phone-item__icon phone-item__icon--small phone-item__icon--telegram">
                        </div>
                    </div>
                    <div class="contacts-popup__phones phone-list">
                        <div class="phone-item">
                            <img src="<?= CORE_PATH; ?>assets/icons/mts.svg" alt="icon-mts"
                                 class="phone-item__icon phone-item__icon--mts">
                            <a href="tel: <?= $mts; ?>" class="phone-item__phone-number"><?= $mts; ?></a>
                        </div>
                        <div class="phone-item">
                            <img src="<?= CORE_PATH; ?>assets/icons/life.svg" alt="icon-life"
                                 class="phone-item__icon phone-item__icon--life">
                            <a href="tel: <?= $life; ?>" class="phone-item__phone-number"><?= $life; ?></a>
                        </div>
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
                    <div class="contacts-popup__working-time-after">
                        <span class="contacts-popup__working-time-after-text"><?= $weekend; ?></span>
                    </div>
                </div>
            </div>

        </div>
    </nav>
    <div class="main-slide">
        <div class="main-slide__slide-img-wrapper"
             style="background-image: url('<?php do_action("mastak_header_small_view_image"); ?>');"></div>
        <div class="main-slide__slide-content">
            <?php do_action("mastak_header_small_view_title"); ?>
        </div>
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
                                value="<?= get_option('rur_currency'); ?>" <?= $currency_name === KGCookie::RUS ? 'selected' : ''; ?>>
                            RUS
                        </option>
                        <option name="<?= KGCookie::USD; ?>"
                                value="<?= get_option('usd_currency'); ?>" <?= $currency_name === KGCookie::USD ? 'selected' : ''; ?>>
                            USD
                        </option>
                        <option name="<?= KGCookie::EUR; ?>"
                                value="<?= get_option('eur_currency'); ?>" <?= $currency_name === KGCookie::EUR ? 'selected' : ''; ?>>
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
                        <div class="menu-bottom__details-sunny">
                            <img class="menu-bottom__sunny-icon" src="<?= $weather[0]["icon"]; ?>"
                                 alt="sunny">
                            <div class="menu-bottom__sunny"><?= $weather[0]["text"]; ?></div>
                        </div>
                        <p class="menu-bottom__degrees"><?= $weather[0]["temp"]; ?>
                            <span>&deg;C</span>
                        </p>
                    </div>
                    <ul class="menu-bottom__days">
                        <li class="menu-bottom__day">
                            <p class="menu-bottom__day-text"><?= $weather[1]["weekday"]; ?></p>
                            <img src="<?= $weather[1]["icon"]; ?>" alt="weather"
                                 class="menu-bottom__day-icon">
                        </li>
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="b-bgc-dark b-py-1">
    <div class="b-container">
        <?php if (function_exists('dimox_breadcrumbs')) {
            dimox_breadcrumbs();
        } ?>
    </div>
</div>
