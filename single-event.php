<?php

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    $price_byn      = (int)get_post_meta(get_the_ID(), "mastak_event_price", true);
    $price          = get_current_price($price_byn);
    $price_subtitle = get_post_meta(get_the_ID(), "mastak_event_price_subtitle", true);
    global $kgCooke;
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];
    $accordion     = get_post_meta(get_the_ID(), "mastak_event_accordion", true);
    $tabs          = mastak_get_event_tabs();

    $date_start  = get_post_meta(get_the_ID(), "mastak_event_date_start", true);
    $date_end    = get_post_meta(get_the_ID(), "mastak_event_date_finish", true);
    $description = get_post_meta(get_the_ID(), "mastak_event_description", true);
    $subtitle    = get_post_meta(get_the_ID(), "mastak_event_subtitle", true);
    $dateCurrent = time();
    $dateAgree   = $dateCurrent < (int)$date_end;

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php if (get_the_ID() == 10188):?>
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Event",
              "name": "The Adventures of Kira and Morrison",
              "startDate": "2025-07-21T19:00",
              "endDate": "2025-07-21T23:00",
              "location": {
                "@type": "Place",
                "name": "Snickerpark Stadium",
                "address": {
                  "@type": "PostalAddress",
                  "streetAddress": "100 West Snickerpark Dr",
                  "addressLocality": "Snickertown",
                  "postalCode": "19019",
                  "addressRegion": "PA",
                  "addressCountry": "US"
                }
              },
              "image": [
                "https://example.com/photos/1x1/photo.jpg",
                "https://example.com/photos/4x3/photo.jpg",
                "https://example.com/photos/16x9/photo.jpg"
               ],
              "description": "The Adventures of Kira and Morrison is coming to Snickertown in a can’t miss performance.",
              "offers": {
                "@type": "Offer",
                "url": "https://www.example.com/event_offer/12345_201803180430",
                "price": "30",
                "priceCurrency": "USD",
                "availability": "https://schema.org/InStock",
                "validFrom": "2024-05-21T12:00"
              },
              "performer": {
                "@type": "PerformingGroup",
                "name": "Kira and Morrison"
              }
            }
        </script>
    <?php endif; ?>
    <?php get_template_part("mastak/views/header", "small-view"); ?>
    <section class="b-container header-title">
        <h2 class="header-title__subtitle"><?= $subtitle; ?></h2>
        <?php if (!empty($date_start)): ?>
            <div class="header-title__date">
                <span><?= date('d.m.Y', $date_start); ?></span>
                <span>&mdash;</span>
                <span><?= date('d.m.Y', $date_end); ?></span>
            </div>
        <?php endif; ?>
    </section>
    <section class="b-container">
        <p class="header-description"><?= $description ?></p>
    </section>
    <div class="b-container b-p-sm-0">
        <div class="accordion-mixed <?= $accordion ? 'accordion-mixed_open' : '' ?>">
            <?php for ($i = 0; $i < count($tabs); $i++): ?>
                <div data-mixed-tab="<?= $i; ?>"
                     class="accordion-mixed__tab <?= $i === 0 ? 'accordion-mixed__tab--active' : '' ?>">
                    <?= $tabs[$i]['name']; ?>
                </div>
                <div data-mixed-conent="<?= $i; ?>"
                     class="accordion-mixed__content <?= $i === 0 ? 'accordion-mixed__content--active' : '' ?>">
                    <?php do_action('mastak_tab_view', $tabs[$i]['id']); ?>
                </div>
            <?php endfor; ?>
            <footer class="house-booking">
                <?php if (isset($price) and !empty($price) and $dateAgree): ?>
                    <?php if ($price != 0): ?>
                        <p class="house-booking__info house-booking__info_event">
                        <span class="house-booking__price-per-men js-currency" data-currency="<?= $currency_name; ?>"
                              data-byn="<?= $price_byn; ?>"><?= $price; ?></span>
                            <span class="opportunity__price-subtitle opportunity__price-subtitle_event"><?= $price_subtitle ?></span>
                        </p>
                    <?php endif; ?>
                    <a href="#booking-order" data-event="<?= get_the_title(); ?>"
                       class="fancybox-inline house-booking__button">забронировать
                    </a>
                <?php endif; ?>
            </footer>
        </div>
    </div>
    <section class="b-bgc-wrapper b-pt-3 b-d-block-md">
        <div class="b-container">
            <div class="b-light-line"></div>
        </div>
    </section>
    <?php
    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    ?>
    <div style="display:none" class="fancybox-hidden">
        <div id="booking-order">
            <p class="booking-order__title"></p>
            <?= do_shortcode('[contact-form-7 id="2730" title="Отправить заявку на бронирование"]'); ?>
        </div>
    </div>
<?php endwhile; endif; // end of the loop. ?>

<?php get_footer('mastak'); ?>