<?php

$options = get_option('mastak_theme_options');

$instagramm    = $options['mastak_theme_options_instagram'];
$tiktok        = $options['mastak_theme_options_tiktok'];

$facebook      = $options['mastak_theme_options_facebook'];
$odnoklassniki = $options['mastak_theme_options_odnoklassniki'];
$vk            = $options['mastak_theme_options_vkontakte'];
$youtobe       = $options['mastak_theme_options_youtube'];
$telegram       = $options['mastak_theme_options_telegram'];
$paymants      = $options['mastak_theme_options_paymants'];
$unp           = $options['mastak_theme_options_unp'];
$location      = $options['mastak_theme_options_location'];
$book          = $options['mastak_theme_options_booking'];
$faq           = $options['mastak_theme_options_faq'];
$email         = $options['mastak_theme_options_email'];

$life           = $options['mastak_theme_options_life'];
$a1         = $options['mastak_theme_options_a1'];
$mts            = $options['mastak_theme_options_mts'];
$footer_logo_id = $options['footer_logo_id'];


$comments = get_comments(array(
    'post_id'      => 9105,
    'status'       => 'approve'
));

// Comment Loop
$ratingCount = count($comments);
$allStars = 0;
foreach ($comments as $comment) {
    $rating = get_comment_meta($comment->comment_ID, 'rating_reviews', 1);

    if (!empty($rating)) {
        $allStars += $rating;
    } else {
        $allStars += 4.25;
    }
}
$ratingValue = number_format($allStars / $ratingCount, 2, '.', '');
$raiting = "Рейтинг: " . $ratingValue . " - " . $ratingCount . " голосов";

?>
<style>
    .contacts-data__item-text.contacts-data__item-text_raiting {
        margin-bottom: 0;
    }

    .footer-bottom__payments {
        display: block;
        width: 100%;
        object-fit: contain;
        padding: .5rem 0;
    }

    .footer-bottom__payments_white {
        background-color: #fff;
    }

    .pb-1 {
        padding-bottom: 1rem;
    }
</style>
<footer class="footer-top">
    <div class="b-container">
        <div class="footer-top__wrapper">
            <div id="top-map" class="footer-top__left footer-top__map">
                <?php if (!wp_is_mobile()) : ?>
                    <script>
                        setTimeout(function() {
                            var tag = document.createElement('script');
                            tag.src = "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6982053e34835c4a2cd060255b90e9bd22635ef01e7c27b0a1d4360632ad4250&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true";
                            tag.defer = true;
                            document.getElementById('top-map').appendChild(tag);
                        }, 5000);
                    </script>
                <?php endif; ?>
            </div>
            <div class="footer-top__right">
                <div class="footer-top__contacts">
                    <div id="small-map" class="footer-top__map--small">
                        <?php if (wp_is_mobile()) : ?>
                            <script>
                                setTimeout(function() {
                                    var tag = document.createElement('script');
                                    tag.src = "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6982053e34835c4a2cd060255b90e9bd22635ef01e7c27b0a1d4360632ad4250&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true";
                                    tag.defer = true;
                                    document.getElementById('small-map').appendChild(tag);
                                }, 5000);
                            </script>
                        <?php endif; ?>
                    </div>
                    <div class="footer-top__contacts-data contacts-data">
                        <div class="contacts-data__first">
                            <a href="<?= $location; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/location.svg" alt="location" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Как доехать?</span>
                                </div>
                            </a>
                            <a href="<?= $book; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/galochka.svg" alt="galochka" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Как забронировать?</span>
                                </div>
                            </a>
                            <a href="<?= $faq; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/support.svg" alt="support" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Популярные вопросы (FAQ)</span>
                                </div>
                            </a>
                            <a href="https://krasnagorka.by/dogovor-prisoedineniya/" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/contract.svg" alt="support" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Договор присоединения</span>
                                </div>
                            </a>
                            <a href="#" class="contacts-data__item" data-cookie-trigger>
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/cookie-icon-white.svg" alt="cookie" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Cookie</span>
                                </div>
                            </a>
                            <a href="https://krasnagorka.by/novosti/" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/news.svg" alt="support" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Новости</span>
                                </div>
                            </a>
                        </div>
                        <div class="contacts-data__second">
                            <div class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/phone.svg" alt="phone" class="contacts-data__item-icon contacts-data__item-icon--top">
                                <div class="contacts-data__item-text-wrapper">
                                    <a href="tel: <?= $a1; ?>" class="contacts-data__item-text contacts-data__item-text_velcom"><?= $a1; ?></a>
                                    <a href="tel: <?= $mts; ?>" class="contacts-data__item-text contacts-data__item-text_mts"><?= $mts; ?></a>
                                    <a href="tel: <?= $life; ?>" class="contacts-data__item-text contacts-data__item-text_life"><?= $life; ?></a>
                                </div>
                            </div>
                            <a href="mailto:<?= $email; ?>" class="contacts-data__item contacts-data__item_email">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/envelope.svg" alt="envelope" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text contacts-data__item-text_raiting"><?= $email; ?></span>
                                </div>
                            </a>
                            <div class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/white_star.svg" alt="envelope" class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text contacts-data__item-text_raiting"><?= $raiting; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-top__form contacts-form">
                    <p class="contacts-form__title">Остались вопросы?</p>
                    <?= do_shortcode('[contact-form-7 id="8893" title="Mastak footer" html_class="contacts-form__forma"]'); ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<footer class="footer-bottom">
    <div class="b-container footer-bottom__content">
        <div class="footer-bottom__wrapper-left footer-bottom-left">
            <?php
            $footer_logo_src = wp_get_attachment_image_src($footer_logo_id, 'footer-logo');
            ?>
            <img class="footer-bottom-left-logo-img" src="<?= $footer_logo_src[0]; ?>" alt="Красногорка" title="Красногорка">
            <div class="footer-bottom-left__socials">
                <?php if (!empty($instagramm)) : ?>
                    <a href="<?= $instagramm; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/insta.svg" alt="Instagram" title="Instagram">
                    </a>
                <?php endif; ?>
                <?php if (!empty($tiktok)) : ?>
                    <a href="<?= $tiktok; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/tiktok.svg" alt="TikTok" title="TikTok">
                    </a>
                <?php endif; ?>
                <?php if (!empty($telegram)) : ?>
                    <a href="<?= $telegram; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/telegram_footer.svg" alt="Telegram" title="Telegram">
                    </a>
                <?php endif; ?>
                <?php if (!empty($vk)) : ?>
                    <a href="<?= $vk; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/vk.svg" alt="Вконтакте" title="Вконтакте">
                    </a>
                <?php endif; ?>
                <?php if (!empty($youtobe)) : ?>
                    <a href="<?= $youtobe; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/youtube_w.svg" alt="Youtube" title="Youtube">
                    </a>
                <?php endif; ?>
                <?php if (!empty($facebook)) : ?>
                    <a href="<?= $facebook; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/fb.svg" alt="Facebook" title="Facebook">
                    </a>
                <?php endif; ?>
                <?php if (!empty($odnoklassniki)) : ?>
                    <a href="<?= $odnoklassniki; ?>" target="_blank">
                        <img class="footer-bottom-left-img" src="<?= CORE_PATH ?>assets/icons/social/ok.svg" alt="Одноклассники" title="Одноклассники">
                    </a>
                <?php endif; ?>
                <div class="footer-bottom-left__text">
                    <p>База отдыха "Красногорка"</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom__wrapper-right footer-bottom-right">
            <div class="footer-bottom-right__banks-icons">

                <?php foreach ($paymants as $paymant) : ?>
                    <img class="footer-bottom-right-img" src="<?= $paymant; ?>" alt="paymant" title="paymant">
                <?php endforeach; ?>
                <iframe class="footer-bottom-right-img" src="https://yandex.by/sprav/widget/rating-badge/191151810278" width="150" height="50" frameborder="0"></iframe>
            </div>
            <div class="footer-bottom-right__description">
                <?= $unp; ?>
            </div>
        </div>
    </div>
    <div class="b-container pb-1">
        <img class="footer-bottom__payments" src="https://krasnagorka.by/wp-content/uploads/2023/03/HORIZONTAL-WHITE.png" alt="payment systems">
        <img class="footer-bottom__payments footer-bottom__payments_white" src="https://krasnagorka.by/wp-content/uploads/2022/05/image_2022-05-26_09-51-49.png" alt="payment systems 2">
    </div>
    
     <?php if(is_page_template("template-mastak-prices.php")):?>
        <!-- Cookie widget START-->
        <div class="cookie_widget" data-cookie-widget hidden>
        <div class="cookie_widget__content">
            <div class="cookie_widget__header">
            <span class="cookie_widget__icon" aria-hidden="true">i</span>
            <div>
                <h2 class="cookie_widget__title">Настройки cookie</h2>
                <p class="cookie_widget__text">
                <span data-cookie-status>Проверяем текущий выбор...</span>
                Подробнее — в
                <a href="/cookie-policy/" class="cookie_widget__link">Политике использования cookie</a>.
                </p>
            </div>
            </div>

            <div class="cookie_widget__toggles" aria-label="Категории cookie">
            <label class="cookie_widget__toggle cookie_widget__toggle_locked">
                <input class="cookie_widget__checkbox" type="checkbox" checked disabled>
                <span class="cookie_widget__toggle_content">
                <strong class="cookie_widget__toggle_title">Необходимые</strong>
                <small class="cookie_widget__toggle_description">Всегда активны: безопасность, согласие и базовая работа сайта</small>
                </span>
            </label>

            <label class="cookie_widget__toggle">
                <input class="cookie_widget__checkbox" type="checkbox" name="preferences" data-consent-option>
                <span class="cookie_widget__toggle_content">
                <strong class="cookie_widget__toggle_title">Предпочтения</strong>
                <small class="cookie_widget__toggle_description">Автозаполнение имени и телефона заказа</small>
                </span>
            </label>

            <label class="cookie_widget__toggle">
                <input class="cookie_widget__checkbox" type="checkbox" name="statistics" data-consent-option>
                <span class="cookie_widget__toggle_content">
                <strong class="cookie_widget__toggle_title">Статистика</strong>
                <small class="cookie_widget__toggle_description">Google Analytics и Yandex Metrica для анализа посещений</small>
                </span>
            </label>

            <label class="cookie_widget__toggle">
                <input class="cookie_widget__checkbox" type="checkbox" name="marketing" data-consent-option>
                <span class="cookie_widget__toggle_content">
                <strong class="cookie_widget__toggle_title">Маркетинг</strong>
                <small class="cookie_widget__toggle_description">Google Ads, ремаркетинг и персонализированные предложения</small>
                </span>
            </label>
            </div>

            <div class="cookie_widget__actions">
            <button class="cookie_widget__button cookie_widget__button_primary" type="button" data-cookie-accept>
                Принять все
            </button>
            <button class="cookie_widget__button" type="button" data-cookie-save>
                Сохранить выбор
            </button>
            <button class="cookie_widget__button cookie_widget__button_ghost" type="button" data-cookie-decline>
                Отказаться
            </button>
            </div>
        </div>
        </div>
        <script>
            (function () {
                const widget = document.querySelector("[data-cookie-widget]");
                const triggers = Array.from(document.querySelectorAll("[data-cookie-trigger]"));
                const status = document.querySelector("[data-cookie-status]");
                const options = Array.from(document.querySelectorAll("[data-consent-option]"));
                const acceptButton = document.querySelector("[data-cookie-accept]");
                const saveButton = document.querySelector("[data-cookie-save]");
                const declineButton = document.querySelector("[data-cookie-decline]");

                const consentCookieName = "kg_cookie_consent";
                const consentCookieMaxAge = 60 * 60 * 24 * 365;
                const orderCookieNames = ["kg_name", "kg_phone", "kg_email"];

                if (!widget || !status) {
                    return;
                }

                const getDataLayer = () => {
                    window.dataLayer = window.dataLayer || [];
                    return window.dataLayer;
                };

                const consentValue = (isGranted) => (isGranted ? "granted" : "denied");
                const hasSecureContext = () => window.location.protocol === "https:";

                const setCookie = (name, value, maxAgeSeconds) => {
                    const secureFlag = hasSecureContext() ? "; Secure" : "";
                    document.cookie = `${name}=${encodeURIComponent(value)}; Path=/; Max-Age=${maxAgeSeconds}; SameSite=Lax${secureFlag}`;
                };

                const getCookie = (name) => {
                    const cookies = document.cookie ? document.cookie.split("; ") : [];
                    const cookie = cookies.find((item) => item.startsWith(`${name}=`));

                    if (!cookie) {
                    return null;
                    }

                    return decodeURIComponent(cookie.slice(name.length + 1));
                };

                const deleteCookie = (name) => {
                    document.cookie = `${name}=; Path=/; Max-Age=0; SameSite=Lax`;
                };

                const clearOrderCookies = () => {
                    orderCookieNames.forEach(deleteCookie);
                };

                const normalizeConsent = (consent) => ({
                    preferences: Boolean(consent?.preferences),
                    statistics: Boolean(consent?.statistics),
                    marketing: Boolean(consent?.marketing),
                });

                const hasOptionalConsent = (consent) =>
                    Boolean(consent.preferences || consent.statistics || consent.marketing);

                const setWidgetOpen = (isOpen) => {
                    widget.hidden = !isOpen;
                };

                const setOptions = (consent) => {
                    options.forEach((option) => {
                    option.checked = Boolean(consent[option.name]);
                    });
                };

                const readOptions = () =>
                    normalizeConsent({
                    preferences: options.find((option) => option.name === "preferences")?.checked,
                    statistics: options.find((option) => option.name === "statistics")?.checked,
                    marketing: options.find((option) => option.name === "marketing")?.checked,
                    });

                const readSavedConsent = () => {
                    const rawConsent = getCookie(consentCookieName);

                    if (!rawConsent) {
                    return null;
                    }

                    try {
                    const parsedConsent = JSON.parse(rawConsent);

                    if (parsedConsent && parsedConsent.version === 1) {
                        return normalizeConsent(parsedConsent.categories);
                    }
                    } catch (error) {
                    deleteCookie(consentCookieName);
                    }

                    return null;
                };

                const saveConsent = (consent) => {
                    setCookie(
                    consentCookieName,
                    JSON.stringify({
                        version: 1,
                        saved_at: new Date().toISOString(),
                        categories: normalizeConsent(consent),
                    }),
                    consentCookieMaxAge
                    );
                };

                const updateMeasurementConsent = (consent) => {
                    const normalizedConsent = normalizeConsent(consent);
                    const consentUpdate = {
                    ad_storage: consentValue(normalizedConsent.marketing),
                    ad_user_data: consentValue(normalizedConsent.marketing),
                    ad_personalization: consentValue(normalizedConsent.marketing),
                    analytics_storage: consentValue(normalizedConsent.statistics),
                    functionality_storage: consentValue(normalizedConsent.preferences),
                    personalization_storage: consentValue(
                        normalizedConsent.preferences || normalizedConsent.marketing
                    ),
                    security_storage: "granted",
                    };

                    if (typeof window.gtag === "function") {
                    window.gtag("consent", "update", consentUpdate);
                    } else {
                    getDataLayer().push(["consent", "update", consentUpdate]);
                    }

                    getDataLayer().push({
                    event: "cookie_consent_update",
                    cookie_preferences: normalizedConsent.preferences,
                    cookie_statistics: normalizedConsent.statistics,
                    cookie_marketing: normalizedConsent.marketing,
                    kg_contact_data_allowed: normalizedConsent.preferences,
                    yandex_metrica_allowed: normalizedConsent.statistics,
                    });

                    if (!normalizedConsent.preferences) {
                    clearOrderCookies();
                    }
                };

                const syncWidget = () => {
                    const savedConsent = readSavedConsent();

                    if (!savedConsent) {
                    status.textContent = "Выберите, какие cookie можно использовать.";
                    setOptions({ preferences: false, statistics: false, marketing: false });
                    setWidgetOpen(true);
                    return;
                    }

                    setOptions(savedConsent);
                    updateMeasurementConsent(savedConsent);

                    if (!hasOptionalConsent(savedConsent)) {
                    status.textContent = "Сейчас активны только необходимые cookie.";
                    setWidgetOpen(true);
                    return;
                    }

                    status.textContent = "Ваш выбор сохранен. Его можно изменить в любой момент.";
                    setWidgetOpen(false);
                };

                const submitConsent = (consent) => {
                    const normalizedConsent = normalizeConsent(consent);

                    saveConsent(normalizedConsent);
                    updateMeasurementConsent(normalizedConsent);
                    syncWidget();
                };

                const openPreferenceCenter = () => {
                    const savedConsent = readSavedConsent();

                    if (savedConsent) {
                    setOptions(savedConsent);
                    }

                    setWidgetOpen(true);
                };

                triggers.forEach((trigger) => {
                    trigger.addEventListener("click", (event) => {
                    event.preventDefault();
                    openPreferenceCenter();
                    });
                });

                acceptButton?.addEventListener("click", () => {
                    submitConsent({ preferences: true, statistics: true, marketing: true });
                });

                saveButton?.addEventListener("click", () => {
                    submitConsent(readOptions());
                });

                declineButton?.addEventListener("click", () => {
                    submitConsent({ preferences: false, statistics: false, marketing: false });
                });

                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", syncWidget);
                } else {
                    syncWidget();
                }

                window.CookieConsentWidget = {
                    open: openPreferenceCenter,
                    getConsent: readSavedConsent,
                    saveContactDraft(contactDraft) {
                    const savedConsent = readSavedConsent();

                    if (!savedConsent?.preferences) {
                        clearOrderCookies();
                        return false;
                    }

                    if (typeof contactDraft.kg_name === "string") {
                        setCookie("kg_name", contactDraft.kg_name.trim(), 60 * 60 * 24 * 30);
                    }

                    if (typeof contactDraft.kg_phone === "string") {
                        setCookie("kg_phone", contactDraft.kg_phone.trim(), 60 * 60 * 24 * 30);
                    }

                    if (typeof contactDraft.kg_email === "string") {
                        setCookie("kg_email", contactDraft.kg_email.trim(), 60 * 60 * 24 * 30);
                    }

                    return true;
                    },
                    saveOrderDraft(orderDraft) {
                    return this.saveContactDraft({
                        kg_name: orderDraft.kg_name ,
                        kg_phone: orderDraft.kg_phone,
                        kg_email: orderDraft.kg_email
                    });
                    },
                    clearOrderCookies,
                };
            })();
        </script>
        <!-- Cookie widget END-->
     <?php endif;?>
</footer>