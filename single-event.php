<?php

    if (!defined('ABSPATH')) {
        exit;
    }

    get_header('mastak');
    $options = get_option('mastak_theme_options');
    $telegram       = $options['mastak_theme_options_telegram'];
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
    $linkTothirdPart    = get_post_meta(get_the_ID(), "mastak_event_link", true);
    $dateCurrent = time();
    $dateAgree   = $dateCurrent < (int)$date_end;

?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

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
        <p class="header-description" style="margin-top: -1rem;margin-bottom: 2rem;">
            Следи за горящими предложениями на телеграм канале 
            <a href=<?=$telegram?> class="css-focused-link" target="_blank">База отдыха «Красногорка» 
                <img src="https://krasnagorka.by/wp-content/themes/krasnagorka/mastak/assets/icons/social/telegram.svg" 
                    alt="icon-telegram" 
                    class="phone-item__icon phone-item__icon--small phone-item__icon--telegram" 
                    style="position:initial;display:inline-block;margin-left: 8px;margin-bottom: -6px;">
        </a>
</p>
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
                    <a href="/booking-form/?booking=<?= get_the_ID() ?>"
                       target="_blank"
                       data-event="<?= get_the_title(); ?>" 
                       class="house-booking__button">забронировать / рассчитать
                    </a>
                <?php elseif (!empty($linkTothirdPart)): ?>
                    <a href="<?= $linkTothirdPart ?>"
                       target="_blank" 
                       class="house-booking__button">забронировать / рассчитать
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
<?php endwhile; endif; // end of the loop. ?>

<?php get_footer('mastak'); ?>