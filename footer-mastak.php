<?php wp_footer();
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
<?php endif;
if (is_page_template("template-mastak-map.php")) : ?>


    <!--ROUTE SCRIPT-->
    <script>
        function googleMapInit() {


            var map_route, routeDirectionsService, marker_route, autocomplete, geocoder;

            var directionsRenderers = [];
            var infoWindows = [];

            //pointsList
            var mapCenter = new google.maps.LatLng(55.695710, 27.022041);
            var mapDestination = new google.maps.LatLng(55.768488, 27.086631);
            var mapStart = new google.maps.LatLng(53.902603, 27.544849);
            var mapSlobodka = new google.maps.LatLng(55.684264, 27.179945);
            var mapMinsk = new google.maps.LatLng(53.90453979999999, 27.561524400000053);
            var mapBegoml = new google.maps.LatLng(54.729464, 28.063619);
            var mapMyadel = new google.maps.LatLng(54.876854, 26.941103);

            function initialize() {

                map_route = new google.maps.Map(document.getElementById('map-route-canvas'), {
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var input = (document.getElementById('pac-input'));
                var button = (document.getElementById('pac-input-button'));

                geocoder = new google.maps.Geocoder();

                map_route.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map_route.controls[google.maps.ControlPosition.TOP_LEFT].push(button);

                autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map_route);

                requestDirections(mapSlobodka, mapDestination, false, google.maps.DirectionsTravelMode.WALKING);

                marker_route = new google.maps.Marker({
                    map: map_route,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                var infowindowDest = new google.maps.InfoWindow({
                    map: map_route,
                    position: mapDestination,
                    content: '<div><strong>Красногорка</strong><br>'
                });
                infoWindows.push(infowindowDest);

                var infowindowSlob = new google.maps.InfoWindow({
                    map: map_route,
                    position: mapSlobodka,
                    content: '<div><strong>Слободка</strong><br>'
                });
                infoWindows.push(infowindowSlob);

                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    showRoute(place.geometry.location)
                });
            }

            //this function make route request
            function requestDirections(start, end, provideRouteAlternatives, travelMode) {
                routeDirectionsService = new google.maps.DirectionsService();

                var requestForRouteMap = {
                    origin: start,
                    destination: end,
                    travelMode: travelMode,
                    provideRouteAlternatives: provideRouteAlternatives
                };

                routeDirectionsService.route(requestForRouteMap, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {

                        for (var i = 0, len = response.routes.length; i < len; i++) {
                            var directionsRenderer = new google.maps.DirectionsRenderer({
                                map: map_route,
                                directions: response,
                                routeIndex: i,
                                suppressmarker: true, //route selectors delete (white points)
                                polylineOptions: {
                                    strokeColor: "#c3242a"
                                }
                            });
                            directionsRenderers.push(directionsRenderer);
                        }
                    } else {
                        $("#error").append("Unable to retrieve your route<br />");
                    }
                });
            }

            //handel Enter key presses: request geotag for value from textbox, and call showRoute()
            function codeAddress() {
                var address = document.getElementById('pac-input').value;
                geocoder.geocode({
                    'address': address
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        showRoute(results[0].geometry.location);
                    } else {
                        alert('Такого места не найдено');
                    }
                });
            }

            //show route from startPosition to mapSlobodka and from mapSlobodka to mapDestination.
            //especially route for Minsk
            function showRoute(startPosition) {
                clearMap();

                marker_route.setVisible(false);

                marker_route.setPosition(startPosition);
                marker_route.setVisible(true);

                requestDirections(mapSlobodka, mapDestination, false, google.maps.DirectionsTravelMode.WALKING);

                //Minsk is especially city :)
                if (startPosition.lat() < 54.0 && startPosition.lat() > 53.7 && startPosition.lng() > 27.3 && startPosition.lng() < 27.7) {
                    requestDirections(startPosition, mapBegoml, false, google.maps.DirectionsTravelMode.DRIVING);
                    requestDirections(mapBegoml, mapSlobodka, false, google.maps.DirectionsTravelMode.DRIVING);
                    requestDirections(startPosition, mapMyadel, false, google.maps.DirectionsTravelMode.DRIVING);
                    requestDirections(mapMyadel, mapSlobodka, false, google.maps.DirectionsTravelMode.DRIVING);
                } else {
                    requestDirections(startPosition, mapSlobodka, true, google.maps.DirectionsTravelMode.DRIVING);
                }

                var infowindowDest = new google.maps.InfoWindow({
                    map: map_route,
                    position: mapDestination,
                    content: '<div><strong>Красногорка</strong><br>'
                });
                infoWindows.push(infowindowDest);
            }

            function clearMap() {
                for (var i = 0; i < directionsRenderers.length; i++)
                    directionsRenderers[i].setMap(null);
                for (var i = 0; i < infoWindows.length; i++)

                    infoWindows[i].setMap(null);
            }

            //analise every transmittable event, and if "Enter" pressed start codeAddress().
            function isEnterPressed(d, e) {
                if (d != "" && e.keyCode == 13)
                    codeAddress();
            }

            setTimeout(function() {
                initialize();
            }, 3000);

            // google.maps.event.addDomListener(window, 'load', initialize);
        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBYTA7whVF5uj5xTK_CghQf19XbhwX_6nI&signed_in=false&libraries=places&callback=googleMapInit"></script>


<?php endif; ?>

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

        $('.accordion-mixed__tab').on('click', function(){
            if($( window ).width() < 768){
                setTimeout(()=>{
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $(this).offset().top
                    }, 400);
                },400);
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
</style>
<script>
    jQuery(document).ready(function() {
        jQuery("#kg-loader").delay(1000).fadeOut(300, function() {
            jQuery("#kg-loader").remove();
        });
    });
</script>
</body>

</html>