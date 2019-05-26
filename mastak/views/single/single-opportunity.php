<?php
    $targetOpen = get_post_meta(get_the_ID(), "new_page", true) ? '_blank' : '_self';
?>
<a href="<?= get_permalink(); ?>" class="swiper-slide opportunity" target="<?= $targetOpen; ?>">
    <div class="opportunity__text">
        <p class="opportunity__title"><?= get_the_title(); ?></p>
        <p class="opportunity__description">
            <?= get_post_meta(get_the_ID(), "mastak_event_description", true); ?>
        </p>
        <div class="opportunity__flag flag flag--b-red flag--b "
             style="--bg-color: <?= get_post_meta(get_the_ID(), "mastak_event_frame_color", true); ?>">
            <div class="flag__inner">
                <img class="flag__icon" src="<?= get_post_meta(get_the_ID(), "mastak_event_icon", true); ?>" alt="icon">
            </div>
        </div>
    </div>
    <div class="opportunity__image-wrapper">
        <?php the_post_thumbnail('medium', ['class' => 'opportunity__image']); ?>
    </div>
</a>