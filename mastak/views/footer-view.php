<?php

    $options = get_option('mastak_theme_options');

    $instagramm    = $options['mastak_theme_options_instagram'];
    $facebook      = $options['mastak_theme_options_facebook'];
    $odnoklassniki = $options['mastak_theme_options_odnoklassniki'];
    $vk            = $options['mastak_theme_options_vkontakte'];
    $youtobe       = $options['mastak_theme_options_youtube'];
    $paymants      = $options['mastak_theme_options_paymants'];
    $unp           = $options['mastak_theme_options_unp'];
    $location      = $options['mastak_theme_options_location'];
    $book          = $options['mastak_theme_options_booking'];
    $faq           = $options['mastak_theme_options_faq'];
    $email         = $options['mastak_theme_options_email'];

    $life           = $options['mastak_theme_options_life'];
    $velcom         = $options['mastak_theme_options_velcome'];
    $mts            = $options['mastak_theme_options_mts'];
    $footer_logo_id = $options['footer_logo_id'];

?>

<footer class="footer-top">
    <div class="b-container">
        <div class="footer-top__wrapper">
            <div id="top-map" class="footer-top__left footer-top__map">
                <?php if(!wp_is_mobile()):?>
                    <script>
                        setTimeout(function(){
                            var tag = document.createElement('script');
                            tag.src = "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A78e4c2c77037e73bd8d8ee81e1d9f12cb332ba73769fc3f6b73537f40d72dccc&amp;width=100%25&amp;height=350&amp;lang=ru_RU&amp;scroll=true";
                            tag.defer = true;
                            document.getElementById('top-map').appendChild(tag);
                        }, 3000);
                    </script>
                <?php endif;?>
            </div>
            <div class="footer-top__right">
                <div class="footer-top__contacts">
                    <div id="small-map" class="footer-top__map--small">
                        <?php if(wp_is_mobile()):?>
                            <script>
                                setTimeout(function(){
                                    var tag = document.createElement('script');
                                    tag.src = "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A78e4c2c77037e73bd8d8ee81e1d9f12cb332ba73769fc3f6b73537f40d72dccc&amp;width=100%25&amp;height=275&amp;lang=ru_RU&amp;scroll=true";
                                    tag.defer = true;
                                    document.getElementById('small-map').appendChild(tag);
                                }, 3000);
                            </script>
                        <?php endif;?>
                    </div>
                    <div class="footer-top__contacts-data contacts-data">
                        <div class="contacts-data__first">
                            <a href="<?= $location; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/location.svg"
                                     alt="location"
                                     class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Как доехать?</span>
                                </div>
                            </a>
                            <a href="<?= $book; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/galochka.svg"
                                     alt="galochka"
                                     class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Как забронировать?</span>
                                </div>
                            </a>
                            <a href="<?= $faq; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/support.svg"
                                     alt="support"
                                     class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text">Популярные вопросы (FAQ)</span>
                                </div>
                            </a>
                        </div>
                        <div class="contacts-data__second">
                            <div class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/phone.svg" alt="phone"
                                     class="contacts-data__item-icon contacts-data__item-icon--top">
                                <div class="contacts-data__item-text-wrapper">
                                    <a href="tel: <?= $velcom; ?>" class="contacts-data__item-text"><?= $velcom; ?></a>
                                    <a href="tel: <?= $mts; ?>" class="contacts-data__item-text"><?= $mts; ?></a>
                                    <a href="tel: <?= $life; ?>" class="contacts-data__item-text"><?= $life; ?></a>
                                </div>
                            </div>
                            <a href="mailto:<?= $email; ?>" class="contacts-data__item">
                                <img src="<?= CORE_PATH ?>assets/icons/contacts-data/envelope.svg"
                                     alt="envelope"
                                     class="contacts-data__item-icon">
                                <div class="contacts-data__item-text-wrapper">
                                    <span class="contacts-data__item-text"><?= $email; ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer-top__form contacts-form">
                    <p class="contacts-form__title">Оставить заявку на бронирование</p>
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
            <img class="footer-bottom-left-logo-img" src="<?= $footer_logo_src[0]; ?>"
                 alt="Красногорка"
                 title="Красногорка">
            <div class="footer-bottom-left__socials">
                <?php if (!empty($instagramm)): ?>
                    <a href="<?= $instagramm; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/insta.svg"
                             alt="Instagram"
                             title="Instagram">
                    </a>
                <?php endif; ?>
                <?php if (!empty($facebook)): ?>
                    <a href="<?= $facebook; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/fb.svg"
                             alt="Facebook"
                             title="Facebook">
                    </a>
                <?php endif; ?>
                <?php if (!empty($odnoklassniki)): ?>
                    <a href="<?= $odnoklassniki; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/ok.svg"
                             alt="Одноклассники"
                             title="Одноклассники">
                    </a>
                <?php endif; ?>
                <?php if (!empty($vk)): ?>
                    <a href="<?= $vk; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/vk.svg"
                             alt="Вконтакте"
                             title="Вконтакте">
                    </a>
                <?php endif; ?>
                <?php if (!empty($youtobe)): ?>
                    <a href="<?= $youtobe; ?>" target="_blank">
                        <img class="footer-bottom-left-img"
                             src="<?= CORE_PATH ?>assets/icons/social/youtube_w.svg"
                             alt="Youtube"
                             title="Youtube">
                    </a>
                <?php endif; ?>
                <div class="footer-bottom-left__text">
                    <p>База отдыха "Красногорка"</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom__wrapper-right footer-bottom-right">
            <div class="footer-bottom-right__banks-icons">

                <?php foreach ($paymants as $paymant): ?>
                    <img class="footer-bottom-right-img"
                         src="<?= $paymant; ?>"
                         alt="paymant"
                         title="paymant">
                <?php endforeach; ?>
            </div>
            <div class="footer-bottom-right__description">
                <?= $unp; ?>
            </div>
        </div>
    </div>
</footer>
