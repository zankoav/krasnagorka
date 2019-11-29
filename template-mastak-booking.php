<?php
    /**ssh krasnago@93.125.99.61
     * ssh krasnago@93.125.99.61
     *
     * Template Name: Booking (redesign)
     *
     */

    // File Security Check
    if (!defined('ABSPATH')) {
        exit;
    }

    $price = get_current_price($price_byn);

    global $kgCooke;
    $currency_name = $kgCooke->getCurrnecy()["currency_selected"];

    get_header('mastak');
    get_template_part("mastak/views/header", "small-view");

    $houses_query = new WP_Query(array(
        'post_type'      => 'house',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_key'       => 'mastak_house_order',
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC'
    ));

?>
    <section class="b-container header-title">
        <?php if (is_user_logged_in()): ?>
            <style>
                #admin-month, #admin-years {
                    margin-left : 2rem;
                    font-size   : 18px;
                    height      : 36px;
                    min-width   : 120px;
                }
            </style>
            <a href="#" class="our-house__button booking-houses__calendars-all-button">Открыть все календари</a>
            <select id="admin-years" name="admin-years">
                <?php for ($year = 2015; $year < 2050; $year++): ?>
                    <option <?= $year == date('Y') ? 'selected' : ''; ?> value="<?= $year; ?>"><?= $year; ?></option>
                <?php endfor; ?>
            </select>
            <select id="admin-month" name="admin-month">
                <option selected value="01">Январь</option>
                <option value="02">Февраль</option>
                <option value="03">Март</option>
                <option value="04">Апрель</option>
                <option value="05">Май</option>
                <option value="06">Июнь</option>
                <option value="07">Июль</option>
                <option value="08">Август</option>
                <option value="09">Сентябрь</option>
                <option value="10">Октябрь</option>
                <option value="11">Ноябрь</option>
                <option value="12">Декабрь</option>
            </select>
        <?php endif; ?>
    </section>
    <section class="b-container">
        <?php get_template_part('mastak/views/icons-description'); ?>
        <div class="select-helper select-helper_header">
            <img src="/wp-content/themes/krasnagorka/mastak/assets/icons/date-clicking-selecting.png"
                 class="select-helper__img" alt="Выделение дат заезда и выезда">
            <p class="select-helper__text"><?= get_option('mastak_theme_options')['calendar_settings_message_before']; ?></p>
        </div>
    </section>
    <section class="b-container">
        <div class="booking-houses">
            <?php while ($houses_query->have_posts()) {
                $houses_query->the_post();
                $isTerem = get_post_meta(get_the_ID(), 'mastak_house_is_it_terem', true);
                if (!$isTerem) {
                    get_template_part('mastak/views/booking', 'house');
                } else if ($isTerem) {
                    $terem_options = get_option('mastak_terem_appearance_options');
                    $kalendars     = $terem_options['kalendar'];
                    foreach ($kalendars as $kalendar) : ?>
                        <div class="booking-houses__wrapper booking-houses__wrapper_terem">
                            <div class="booking-houses__item">
                                <div class="booking-houses__header">
                                    <h2 class="booking-houses__title our-house__title"><?= $kalendar['title']; ?></h2>
                                </div>
                                <a href="<?= get_the_permalink(); ?>" target="_blank"
                                   class="booking-houses__image-wrapper">
                                    <img class="booking-houses__image" src="<?= $kalendar['picture']; ?>"
                                         alt="<?= $kalendar['title']; ?>">
                                </a>
                                <div class="booking-houses__header">
                                    <p class="booking-houses__description">
                                        <?php if (!empty($kalendar['min_people'])): ?>
                                            <span class="booking-houses__description-item"
                                                  data-info="<?= $kalendar['min_people']; ?>"><img
                                                        class="apartment__icon apartment__icon_mr-4px"
                                                        src="<?= CORE_PATH ?>assets/icons/min-01.svg"
                                                        alt="icon">x</span>
                                        <?php endif;
                                            if (!empty($kalendar['max_people'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['max_people']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/max-01.svg"
                                                            alt="icon">x</span>
                                            <?php endif;
                                            if (!empty($kalendar['double_bed'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['double_bed']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/double-king-size-bed.svg"
                                                            alt="icon">x</span>
                                            <?php endif;
                                            if (!empty($kalendar['single_bed'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['single_bed']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/single-king-size-bed.svg"
                                                            alt="icon">x</span>
                                            <?php endif;
                                            if (!empty($kalendar['toilet_and_shower'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['toilet_and_shower']; ?>">
                                                    <img class="apartment__icon apartment__icon_mr--4px"
                                                         src="<?= CORE_PATH ?>assets/icons/toilet.svg"
                                                         alt="icon">
                                                    <img class="apartment__icon apartment__icon_mr-4px"
                                                         src="<?= CORE_PATH ?>assets/icons/shower.svg"
                                                         alt="icon">
                                                    x</span>
                                            <?php endif;
                                            if (!empty($kalendar['toilet'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['toilet']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/toilet.svg"
                                                            alt="icon">x</span>
                                            <?php endif;
                                            if (!empty($kalendar['bed_rooms'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['bed_rooms']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/br-01.svg"
                                                            alt="icon">x</span>
                                            <?php endif;
                                            if (!empty($kalendar['triple_bed'])):?>
                                                <span class="booking-houses__description-item"
                                                      data-info="<?= $kalendar['triple_bed']; ?>"><img
                                                            class="apartment__icon apartment__icon_mr-4px"
                                                            src="<?= CORE_PATH ?>assets/icons/triple-bed.svg"
                                                            alt="icon">x</span>
                                            <?php endif; ?>
                                    </p>
                                </div>
                                <div class="booking-houses__calendars">
                                    <div class="booking-houses__calendars-inner">
                                        <a href="#" data-calendar='<?= $kalendar['calendar']; ?>'
                                           class="our-house__button our-house__button--green booking-houses__calendars-button">
                                            Показать календарь
                                        </a>
                                    </div>
                                    <a href="/booking-form/?booking=<?= get_the_ID() ?>"
                                       target="_blank"
                                       class="our-house__button our-house__button_media_xs our-house__button-hidden our-house__button_mt_15">
                                        забронировать
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                }
            }
                wp_reset_query();
            ?>
        </div>
        <div class="b-light-line b-my-3 b-d-block-sm"></div>
        <div class="booking-houses__text b-my-3">
            <?php the_content(); ?>
        </div>
    </section>
    <style>
        .our-house__button-hidden {
            display : none;
        }

        .our-house__button_mt_15 {
            margin-top : 1.5rem;
        }
    </style>
<?php
    get_template_part("mastak/views/reviews", "view");
    get_template_part("mastak/views/footer", "view");
    get_footer('mastak');

?>