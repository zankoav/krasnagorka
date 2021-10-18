<?php
    $targetOpen = get_post_meta(get_the_ID(), "new_page", true) ? '_blank' : '_self';
?>
<a href="<?= get_permalink(); ?>" class="swiper-slide opportunity" target="<?= $targetOpen; ?>">
    <div class="opportunity__text">
        <p class="opportunity__title"><?= get_the_title(); ?></p>
        <p class="opportunity__description">
            <?= get_post_meta(get_the_ID(), "post_settings_description", true); ?>
        </p>
        <div class="opportunity__flag flag flag--b-red flag--b "
             style="--bg-color: <?= get_post_meta(get_the_ID(), "post_settings_frame_color", true); ?>">
        </div>
    </div>
    <div class="opportunity__image-wrapper">
        <?php the_post_thumbnail('opportunity_small_iphone_5', ['class' => 'object-fit-img']); ?>
    </div>
</a>