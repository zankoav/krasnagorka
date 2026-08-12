<?php

use LsModel\ModelFactory as ModelFactory;

if (!defined('ABSPATH')) {
    exit;
}

$bookingModel = ModelFactory::getBookingModel();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= get_site_icon_url(); ?>" type="image/x-icon">
    <title><?= get_the_title(); ?></title>
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/lwc/frontend/fonts/AvenirNextCyr/fonts.css" rel="stylesheet"/>
    <link href="https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/css/public_style.css" rel="stylesheet"/>
    <style>

        .cookie-policy *,
        .cookie-policy *::before,
        .cookie-policy *::after {
            box-sizing: border-box;
        }

        .cookie-policy {
            width: min(980px, calc(100% - 32px));
            margin: 0 auto;
            padding: 48px 0 72px;
            color: #172026;
        }

        .cookie-policy h2 {
            margin: 38px 0 14px;
            font-size: 1.45rem;
            line-height: 1.2;
        }

        .cookie-policy p {
            max-width: 76ch;
            margin: 0 0 16px;
            color: #4f5f66;
            line-height: 1.65;
        }

        .cookie-policy a {
            color: #0f7b66;
            font-weight: 750;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .cookie-policy table {
            width: 100%;
            margin: 14px 0 24px;
            border-collapse: collapse;
            border: 1px solid #d9e0e4;
            background: #fff;
        }

        .cookie-policy th,
        .cookie-policy td {
            padding: 14px 16px;
            border: 1px solid #d9e0e4;
            text-align: left;
            vertical-align: top;
            line-height: 1.45;
            overflow-wrap: anywhere;
        }

        .cookie-policy th {
            background: #f5f7f8;
            color: #172026;
            font-weight: 800;
        }

        .cookie-policy td {
            color: #4f5f66;
        }

        .cookie-policy code {
            color: #172026;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.92em;
        }

        @media (max-width: 760px) {
            .cookie-policy {
                padding-top: 32px;
            }

            .cookie-policy table,
            .cookie-policy thead,
            .cookie-policy tbody,
            .cookie-policy tr,
            .cookie-policy td {
                display: block;
            }

            .cookie-policy thead {
                display: none;
            }

            .cookie-policy tr {
                padding: 12px 0;
                border-bottom: 1px solid #d9e0e4;
            }

            .cookie-policy tr:last-child {
                border-bottom: 0;
            }

            .cookie-policy td {
                display: grid;
                grid-template-columns: minmax(110px, 34%) 1fr;
                gap: 12px;
                padding: 10px 14px;
                border: 0;
            }

            .cookie-policy td::before {
                content: attr(data-label);
                color: #172026;
                font-weight: 800;
            }

            .cookie-policy code {
                word-break: break-word;
            }
        }

        @media (max-width: 420px) {
            .cookie-policy {
                width: min(100% - 24px, 980px);
            }

            .cookie-policy td {
                grid-template-columns: 1fr;
                gap: 4px;
            }
        }

        /** 
        Cookie widget
        **/

        .cookie_widget {
            color-scheme: light;
            --bg: #f5f7f8;
            --ink: #172026;
            --muted: #5f6c73;
            --line: #d9e0e4;
            --panel: #ffffff;
            --accent: #04a89f;
            --accent-strong: #567573;
            --accent-soft: #dff3ee;
            --warning: #8a4b0f;
            --shadow: 0 18px 50px rgba(23, 32, 38, 0.18);
            font-family:
                Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
                sans-serif;
        }

        .cookie_widget *,
        .cookie_widget *::before,
        .cookie_widget *::after{
            box-sizing: border-box;
        }

        .cookie_widget {
            position: fixed;
            inset: auto 20px 20px auto;
            z-index: 30;
            width: min(440px, calc(100vw - 40px));
        }

        .cookie_widget[hidden] {
            display: none;
        }

        .cookie_widget__content {
            max-height: calc(100vh - 40px);
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
            box-shadow: var(--shadow);
        }

        .cookie_widget__header {
            display: grid;
            grid-template-columns: 38px 1fr;
            gap: 14px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--line);
        }

        .cookie_widget__icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-weight: 800;
        }

        .cookie_widget__title {
            margin: 0 0 5px;
            font-size: 1.1rem;
            letter-spacing: 0;
        }

        .cookie_widget__text {
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.45;
        }

        .cookie_widget__link {
            color: var(--accent-strong);
            font-weight: 750;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .cookie_widget__link:hover {
            color: var(--accent);
        }

        .cookie_widget__toggles {
            max-height: min(320px, calc(100vh - 290px));
            overflow-y: auto;
            display: grid;
            gap: 0;
        }

        .cookie_widget__toggle {
            min-height: 72px;
            display: grid;
            grid-template-columns: 24px 1fr;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--line);
            cursor: pointer;
        }

        .cookie_widget__toggle_locked {
            cursor: default;
        }

        .cookie_widget__checkbox {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
            font: inherit;
                -webkit-appearance: auto !important;
                -moz-appearance:  auto !important;
                appearance:  auto !important;
        }

        .cookie_widget__toggle_content,
        .cookie_widget__toggle_title,
        .cookie_widget__toggle_description {
            display: block;
        }

        .cookie_widget__toggle_title {
            margin-bottom: 3px;
            font-size: 0.95rem;
        }

        .cookie_widget__toggle_description {
            color: var(--muted);
            font-size: 0.8rem;
            line-height: 1.35;
        }

        .cookie_widget__actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 16px 20px 20px;
        }

        .cookie_widget__button {
            min-height: 44px;
            border: 1px solid var(--line);
            border-radius: 7px;
            background: #fff;
            color: var(--ink);
            font-weight: 750;
            font: inherit;
            cursor: pointer;
        }

        .cookie_widget__button:hover {
            border-color: var(--accent);
        }

        .cookie_widget__button_primary {
            border-color: var(--accent);
            background: var(--accent);
            color: #fff;
        }

        .cookie_widget__button_primary:hover {
            border-color: var(--accent-strong);
            background: var(--accent-strong);
        }

        .cookie_widget__button_ghost {
            grid-column: 1 / -1;
            color: var(--warning);
        }

        @media (max-width: 520px) {
            .cookie_widget {
                inset: auto 12px 12px;
                width: auto;
            }

            .cookie_widget__content {
                max-height: calc(100dvh - 24px);
                display: grid;
                grid-template-rows: auto minmax(0, 1fr) auto;
            }

            .cookie_widget__header {
                padding: 16px;
            }

            .cookie_widget__toggles {
                max-height: none;
                min-height: 0;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .cookie_widget__toggle {
                min-height: auto;
                padding: 12px 16px;
            }

            .cookie_widget__actions {
                grid-template-columns: 1fr;
                padding: 14px 16px 16px;
            }

            .cookie_widget__button_ghost {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <script>
        window.gtag = window.gtag || function () {}; 
        const model = `<?= $bookingModel; ?>`;
    </script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery.min.js' id='jquery-core-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/jquery/jquery-migrate.min.js' id='jquery-migrate-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-includes/js/dist/vendor/moment.min.js' id='moment-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/fullcalendar.min.js' id='fullcalendar-js'></script>
    <script type='text/javascript' src='https://krasnagorka.by/wp-content/themes/krasnagorka/inc/calendar/js/ru.js' id='ru-js'></script>
    <script src="<?= $assets->js('booking'); ?>"></script>
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
                } else {
                status.textContent = "Ваш выбор сохранен. Его можно изменить в любой момент.";
                }

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
                    kg_name: orderDraft.kg_name ?? orderDraft.order_name,
                    kg_phone: orderDraft.kg_phone ?? orderDraft.order_phone,
                    kg_email: orderDraft.kg_email ?? orderDraft.order_email,
                });
                },
                clearOrderCookies,
            };
        })();
    </script>
    <!-- Cookie widget END-->
</body>

</html>