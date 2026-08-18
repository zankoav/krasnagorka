<?php wp_footer();
global $assets;
if (is_page_template('reviews-page-template.php')) : ?>
    <script>
        var commentOffset = 20;

        function sendQueryComments(callback) {

            var data = {
                action: 'comments_action',
                range: commentOffset
            };

            jQuery.ajax(kg_ajax.url, {
                data: data,
                method: 'post',
                success: function(response) {
                    callback();
                    commentOffset += 20;
                    var response = JSON.parse(response);
                    if (response.comments.length) {
                        var view = getCommentsView(response.comments);
                        jQuery(".js-comments").append(view);
                    } else {
                        jQuery(".show-more").remove();
                    }
                },
                error: function(x, y, z) {
                    callback();
                }
            });

        }

        function getCommentsView(comments) {
            var result = '';
            for (var comment of comments) {
                var rating = getStars(comment.rating);
                result += `
                        <div id="comment-${comment.id}" class="list-review__item">
                            <div class="review review--full_width">
                                 <div class="review__starts">${rating}</div>
                                 <p class="review__text">${comment.comment_content}</p>
                            </div>
                            <div class="list-review__user">
                                <span class="list-review__user-name">${comment.comment_author}</span>
                                <span class="list-review__user-date">${comment.comment_date}</span>
                            </div>
                        </div>
                    `;
                if (comment.child) {
                    result += `
                            <div class="list-review__item list-review__item_answer">
                                <div class="review review--full_width">
                                    <p class="review__answer">Ответ:</p>
                                    <p class="review__text">${comment.child.content}</p>
                                </div>
                                <div class="list-review__user">
                                    <span class="list-review__user-name">Администратор</span>
                                    <span class="list-review__user-date">${comment.child.date}</span>
                                </div>
                            </div>
                        `;
                }

            }
            return result;
        }

        function getStars(count) {
            if (!count) {
                count = 5;
            }
            count = parseInt(count);
            var result = '';

            for (var i = 1; i <= 5; i++) {
                var title = i <= count ? '' : 'empty-';
                result += `<img src="/wp-content/themes/krasnagorka/mastak/assets/icons/${title}star.svg"
                         alt="star"
                         class="review__star">`
            }
            return result;
        }
    </script>
<?php endif; ?>

<script type="text/javascript">
    (function($) {

        document.addEventListener('wpcf7mailsent', function(event) {
            console.log('contactFormId', event.detail.contactFormId);
            if (event.detail.contactFormId == '2730') {
                var year = 3600 * 24 * 365;
                var $inputName = $('[name="your-name"]');
                var $inputPhone = $('[name="tel"]');
                var $inputEmail = $('[name="your-email"]');
                if (window.CookieConsentWidget?.getConsent().preferences) {
                    setCookie('kg_name', $inputName.val(), {
                        expires: year,
                        path: '/'
                    });
                    setCookie('kg_email', $inputEmail.val(), {
                        expires: year,
                        path: '/'
                    });
                    setCookie('kg_phone', $inputPhone.val(), {
                        expires: year,
                        path: '/'
                    });
                } else {
                    deleteCookie('kg_name')
                    deleteCookie('kg_phone')
                    deleteCookie('kg_email')
                }
                
            }
        }, false);

        $('.our-house__button, .house-booking__button').on('click', function() {

            var name = getCookie('kg_name');
            var email = getCookie('kg_email');
            var phone = getCookie('kg_phone');


            var $inputName = $('[name="your-name"]');
            var $inputPhone = $('[name="tel"]');
            var $inputEmail = $('[name="your-email"]');


            if (name && $inputName.val() == '') {
                $inputName.val(name);
            }

            if (email && $inputEmail.val() == '') {
                $inputEmail.val(email);
            }

            if (phone && $inputPhone.val() == '+') {
                $inputPhone.val(phone);
            }

        });


        function setCookie(name, value, props) {
            props = props || {};
            var exp = props.expires;
            if (typeof exp == "number" && exp) {
                var d = new Date();
                d.setTime(d.getTime() + exp * 1000);
                exp = props.expires = d;
            }

            if (exp && exp.toUTCString) {
                props.expires = exp.toUTCString();
            }
            value = encodeURIComponent(value);
            var updatedCookie = name + "=" + value;
            for (var propName in props) {

                updatedCookie += "; " + propName;

                var propValue = props[propName]

                if (propValue !== true) {
                    updatedCookie += "=" + propValue;
                }
            }

            document.cookie = updatedCookie;

        }

    })(jQuery);

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    const deleteCookie = (name) => {
        document.cookie = `${name}=; Path=/; Max-Age=0; SameSite=Lax`;
    };
</script>

<script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-85853604-1', 'auto');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');

    var cid = getCookie("_ga");
    cid = cid.replace(/GA1.2./g, '');
    jQuery('[name="user-cid"]').val(cid);
</script>

<script type="text/javascript">
    (function(w, d) {
        setTimeout(function() {
            w.amo_jivosite_id = 'vPugBTo6M7';
            var s = document.createElement('script'),
                f = d.getElementsByTagName('script')[0];
            s.id = 'amo_jivosite_js';
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://forms.amocrm.ru/chats/jivosite/jivosite.js';
            f.parentNode.insertBefore(s, f);
        }, 3000);
    })(window, document);

    function jivo_onIntroduction() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'JivoSite',
            eventAction: 'User gave contacts during chat'
        });
    }

    function jivo_onAccept() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'JivoSite',
            eventAction: 'Chat established'
        });
    }

    function jivo_onMessageSent() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'JivoSite',
            eventAction: 'First Message sent'
        });
    }
</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- Код тега ремаркетинга Google -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 859598761;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script async type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/859598761/?guid=ON&amp;script=0" />
    </div>
</noscript>
<script>
    // Menu Contacts button
    jQuery('.contacts-menu__button--phone').click(function() {
        if (!jQuery(this).hasClass('contacts-menu__button_active')) {
            ga('send', {
                hitType: 'event',
                eventCategory: 'tel_menu',
                eventAction: 'click'
            });
        }
    });

    // Email
    jQuery('.contacts-popup__email-text, .contacts-data__item_email').click(function() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'email',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_velcom, .phone-item__phone-number_velcom').click(function() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_velcom',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_mts, .phone-item__phone-number_mts').click(function() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_mts',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_life, .phone-item__phone-number_life').click(function() {
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_life',
            eventAction: 'click'
        });
    });

    jQuery('.our-house__button-numbers').on('click', function() {
        jQuery('.terem-calendars').slideToggle();
    });


    (function($) {

        $('.our-house__button, .house-booking__button').on('click', function() {
            let name = $(this).data('name');
            let prefix = 'Home ';
            let category = 'house';
            if (!name) {
                name = $(this).data('event');
                prefix = 'Event ';
                category = 'events';
            }
            if (!name) {
                console.log('Error ga');
                return;
            }

            ga('send', {
                hitType: 'event',
                eventCategory: category,
                eventAction: 'click',
                eventLabel: prefix + name
            });
        });

        $('.accordion-mixed__tab').on('click', function() {
            if ($(window).width() < 768) {
                setTimeout(() => {
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $(this).offset().top
                    }, 400);
                }, 400);
            }
        });
    })(jQuery);

    document.addEventListener('wpcf7mailsent', function(event) {

        if ('9102' == event.detail.contactFormId) {
            ga('send', {
                hitType: 'event',
                eventCategory: 'forma_questions',
                eventAction: 'otpravit'
            });
        }

        if ('8893' == event.detail.contactFormId) {
            ga('send', {
                hitType: 'event',
                eventCategory: 'form_foot',
                eventAction: 'otpravit'
            });
        }

    }, false);


    jQuery('.base-place__coordinate-inner')
        .on('click', function() {
            CopyToClipboard('coordinate');
            var tooltip = document.getElementById("coordinatsTooltip");
            tooltip.innerHTML = "Координаты скопированы";
        })
        .on('mouseout', function() {
            var tooltip = document.getElementById("coordinatsTooltip");
            tooltip.innerHTML = "Копировать координаты?";
        });

    function CopyToClipboard(containerid) {
        var el = document.getElementById(containerid);
        var range = document.createRange();
        range.selectNodeContents(el);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        document.execCommand('copy');
    }
</script>
<!-- Код CallTracking -->
<script async src="//app.call-tracking.by/scripts/phones.js?8827b1a7-3494-4e5e-abe2-d46e6c2f1728"></script>
<style>
    .button-animation {
        animation: buttonShake .8s;
    }

    img.footer-bottom-left-img {
        margin-bottom: 0.5rem;
    }

    div.footer-bottom-left__socials {
        text-align: center;
    }

    @keyframes buttonShake {
        0% {
            background-color: #d0021b
        }

        50% {
            background-color: #04a89f
        }

        100% {
            background-color: #d0021b
        }
    }

    .select-helper {
        display: flex;
        align-items: center;
        padding: 15px 15px 0 15px;
    }

    .select-helper_header {
        font-size: 14px;
        padding: 0 0 1rem;
        align-items: flex-start;
    }

    .select-helper_header .select-helper__img {
        max-width: 26px;
    }

    @media (min-width : 1280px) {
        .select-helper_header {
            align-items: center;
            font-size: 16px;
            padding: 0 0 2rem;
        }

        .select-helper_header .select-helper__img {
            max-width: 2.5rem;
        }
    }

    .select-helper__img {
        flex-shrink: 0;
        max-width: 2rem;
        margin-right: 1rem;
    }

    .select-helper__img {
        flex-shrink: 0;
        max-width: 2.5rem;
        margin-right: 1rem;
    }

    .select-helper__text {
        flex: 1;
        font-size: 14px;
    }

    .select-helper__text_success {
        color: #04a89f
    }

    .our-house__calendar,
    .booking-houses__calendars-inner {
        position: static;
    }

    .our-house__button-hidden {
        display: none;
    }

    .our-house__button_mt_15 {
        margin-top: 1.5rem;
    }

    .cell-between,
    .cell-range {
        background-color: rgb(188, 232, 241);
    }

    .fc-day-event__icon {
        position: absolute;
        bottom: 4px;
        left: 4px;
        width: 16px;
        height: 16px;
        object-fit: contain;
    }
</style>
<script>
    
    jQuery(document).ready(function() {
        jQuery("#kg-loader").delay(1000).fadeOut(300, function() {
            jQuery("#kg-loader").remove();
        });
    });
</script>

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