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
<?php endif;?>

<script type="text/javascript">
    (function($) {

        document.addEventListener('wpcf7mailsent', function(event) {
            if (event.detail.contactFormId == '2730') {
                var year = 3600 * 24 * 365;
                var $inputName = $('[name="your-name"]');
                var $inputPhone = $('[name="tel"]');
                var $inputEmail = $('[name="your-email"]');
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

    jQuery('.our-house__button-numbers').on('click', function(){
        jQuery('.terem-calendars').slideToggle();
        if ($(this).is(':visible')){
            $(this).css('display','flex');
        }
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

    jQuery('.online-video').on('click', function() {
        jQuery('.modal-online-video').fadeIn(function() {
            var img = new Image();
            img.src = 'http://375297763819.dyndns.mts.by:1081/videostream.cgi?user=veter&pwd=veter&resolution=32';
            img.onload = function() {
                var closeButton = document.createElement('div');
                closeButton.setAttribute('class', 'modal-online-video__close');
                closeButton.addEventListener('click', modalClose);
                jQuery('.modal-online-video__video').empty().append(img).append(closeButton);
            }
        });
    });

    jQuery('.modal-online-video__container').on('click', modalClose);

    function modalClose() {
        jQuery('.modal-online-video').fadeOut(function() {
            jQuery('.modal-online-video__video').empty().html('<div class="modal-online-video__spinner"></div>');
        })
    }


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
<script async src="//app.call-tracking.by/scripts/calltracking.js?8827b1a7-3494-4e5e-abe2-d46e6c2f1728"></script>
<style>
    .button-animation {
        animation: buttonShake .8s;
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

    .fc-day-event__icon{
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
<script src="<?= $assets->js('cookie'); ?>"></script>
</body>

</html>