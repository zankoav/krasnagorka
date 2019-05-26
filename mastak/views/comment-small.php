<?php
	global $comment;
	$delay = get_option( 'mastak_theme_options' )['mastak_theme_options_slider_delay'];
	$rating = get_comment_meta( $comment->comment_ID, 'rating_reviews', 1 );
	if ( $rating == 5 ): ?>
        <div class="swiper-slide reviews__item" data-swiper-autoplay="<?=$delay;?>">
            <div class="review review_flex">
				<?php if (!get_option( 'mastak_theme_options' )['mastak_theme_options_hide_stars']) : ?>
                    <div class="review__starts">
						<?php getStars( $rating ); ?>
                    </div>
				<?php endif; ?>
                <p class="review__text review__text_size_small"><?= wp_trim_words($comment->comment_content, 24); ?></p>
                <a href="<?= get_comment_link($comment->comment_ID);?>" class="review__link" target="_blank">Дочитать</a>
            </div>
            <p class="reviews__item-name"><?= $comment->comment_author; ?></p>
        </div>
	<?php endif; ?>
