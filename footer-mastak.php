<?php wp_footer();
    if (is_page_template("template-mastak-map.php")): ?>



        <!--        GGG-->


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

                    google.maps.event.addListener(autocomplete, 'place_changed', function () {
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

                    routeDirectionsService.route(requestForRouteMap, function (response, status) {
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
                    geocoder.geocode({'address': address}, function (results, status) {
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

                setTimeout(function () {
                    initialize();
                }, 3000);

                // google.maps.event.addDomListener(window, 'load', initialize);
            }
        </script>
        <script async src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBYTA7whVF5uj5xTK_CghQf19XbhwX_6nI&signed_in=false&libraries=places&callback=googleMapInit"></script>


    <?php endif; ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter37788340 = new Ya.Metrika({
                    id: 37788340,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div>
        <img src="https://mc.yandex.ru/watch/37788340" style="position:absolute; left:-9999px;" alt=""/>
    </div>
</noscript>
<!-- /Yandex.Metrika counter -->


<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
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

</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<!--<script type='text/javascript'>-->
<!--    (function () {-->
<!--        var widget_id = '38m4hDlF7s';-->
<!--        var d = document;-->
<!--        var w = window;-->
        
<!--        function l() {-->
<!--            var s = document.createElement('script');-->
<!--            s.type = 'text/javascript';-->
<!--            s.async = true;-->
<!--            s.src = '//code.jivosite.com/script/widget/' + widget_id;-->
<!--            var ss = document.getElementsByTagName('script')[0];-->
<!--            ss.parentNode.insertBefore(s, ss);-->
<!--        }-->
        
<!--        if (d.readyState == 'complete') {-->
<!--            l();-->
<!--        } else {-->
<!--            if (w.attachEvent) {-->
<!--                w.attachEvent('onload', l);-->
<!--            } else {-->
<!--                w.addEventListener('load', l, false);-->
<!--            }-->
<!--        }-->
<!--    })();</script>-->
<!-- {/literal} END JIVOSITE CODE -->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type="text/javascript">
    (function (w, d) {
        setTimeout(function () {
            
            // (function () {
            //     var widget_id = '38m4hDlF7s';
            //     var d = document;
            //     var w = window;
                
            //     function l() {
            //         var s = document.createElement('script');
            //         s.type = 'text/javascript';
            //         s.async = true;
            //         s.src = '//code.jivosite.com/script/widget/' + widget_id;
            //         var ss = document.getElementsByTagName('script')[0];
            //         ss.parentNode.insertBefore(s, ss);
            //     }
                
            //     if (d.readyState == 'complete') {
            //         l();
            //     } else {
            //         if (w.attachEvent) {
            //             w.attachEvent('onload', l);
            //         } else {
            //             w.addEventListener('load', l, false);
            //         }
            //     }
            // })();
            
            w.amo_jivosite_id = 'vPugBTo6M7';
            var s = document.createElement('script'), f = d.getElementsByTagName('script')[0];
            s.id = 'amo_jivosite_js';
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://forms.amocrm.ru/chats/jivosite/jivosite.js';
            f.parentNode.insertBefore(s, f);
            
        }, 3000);
    })(window, document);

    function jivo_onIntroduction(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'JivoSite',
            eventAction: 'User gave contacts during chat'
        });
    }

    function jivo_onAccept(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'JivoSite',
            eventAction: 'Chat established'
        });
    }

    function jivo_onMessageSent(){
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
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt=""
             src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/859598761/?guid=ON&amp;script=0"/>
    </div>
</noscript>
<script>

    // Menu Contacts button
    jQuery('.contacts-menu__button--phone').click(function(){
        if(!jQuery(this).hasClass('contacts-menu__button_active')){
            ga('send', {
                hitType: 'event',
                eventCategory: 'tel_menu',
                eventAction: 'click'
            });
        }
    });

    // Email
    jQuery('.contacts-popup__email-text, .contacts-data__item_email').click(function(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'email',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_velcom, .phone-item__phone-number_velcom').click(function(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_velcom',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_mts, .phone-item__phone-number_mts').click(function(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_mts',
            eventAction: 'click'
        });
    });

    jQuery('.contacts-data__item-text_life, .phone-item__phone-number_life').click(function(){
        ga('send', {
            hitType: 'event',
            eventCategory: 'phone_life',
            eventAction: 'click'
        });
    });

    jQuery('[href="#booking-order"]').click(function(){
        let name = jQuery(this).data('name');
        let prefix = 'Home ';
        let category = 'house';
        if(!name){
            name = jQuery(this).data('event');
            prefix = 'Event ';
            category = 'events';
        }
        if(!name){
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

    document.addEventListener('wpcf7mailsent', function (event) {

        if ('2730' == event.detail.contactFormId) {
            ga('send', {
                hitType: 'event',
                eventCategory: 'form_bronirovanie',
                eventAction: 'success_send'
            });
        }

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


    var videoTimer;
    jQuery('.online-video').on('click', function () {
        jQuery('.modal-online-video').fadeIn(function () {
            videoTimer = setInterval(function () {
                var img = new Image();
                img.src = 'http://375297763819.dyndns.mts.by:1081/snapshot.cgi?user=veter&pwd=veter&time='+(new Date()).getTime();
                img.onload = function(){
                    jQuery('.modal-online-video__video').empty().append(img);
                }
            }, 60);
        });
    });

    jQuery('.modal-online-video__container').on('click', function () {
        jQuery('.modal-online-video').fadeOut(function () {
            clearInterval(videoTimer);
        })
    });


</script>
<!-- Код CallTracking -->
<script async src="//app.call-tracking.by/scripts/calltracking.js?8827b1a7-3494-4e5e-abe2-d46e6c2f1728"></script>
</body>
</html>