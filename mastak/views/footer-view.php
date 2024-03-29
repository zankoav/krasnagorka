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
</footer>