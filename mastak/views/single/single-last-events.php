<?php
    $targetOpen = get_post_meta(get_the_ID(), "new_page", true) ? '_blank' : '_self';
?>
<div class="swiper-slide last-events__item">
    <a href="<?= get_permalink(); ?>" class="last-event" target="<?=$targetOpen;?>">
		<?php the_post_thumbnail( 'medium', [ 'class' => 'last-event__icon' ] ); ?>
        <div class="last-event__content">
            <p class="last-event__title"><?= get_the_title(); ?></p>
            
        </div>
    </a>
</div>