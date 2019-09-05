<?php

	/**
	 * @var WP_Comment $comment
	 */
	global $comment;
	$children = $comment->get_children();
	$rating = get_comment_meta( $comment->comment_ID, 'rating_reviews', 1 );
?>
<div id="comment-<?=$comment->comment_ID;?>" class="list-review__item">
    <div class="review review--full_width">
		<?php if ( !get_option( 'mastak_theme_options' )['mastak_theme_options_hide_stars'] ) : ?>
            <div class="review__starts">
				<?php getStars( $rating ); ?>
            </div>
		<?php endif; ?>
        <p class="review__text"><?= $comment->comment_content; ?></p>
    </div>
    <div class="list-review__user">
        <span class="list-review__user-name"><?= $comment->comment_author; ?></span>
        <span class="list-review__user-date"><?= date( "d.m.Y", strtotime( $comment->comment_date ) ); ?></span>
    </div>

    <?php foreach ($children as $child) :?>
        <div class="list-review__item list-review__item_answer">
            <div class="review review--full_width">
			    <p class="review__answer">Ответ:</p>
                <p class="review__text"><?= $child->comment_content; ?></p>
            </div>
            <div class="list-review__user">
                <span class="list-review__user-name">Администратор</span>
                <span class="list-review__user-date"><?= date( "d.m.Y", strtotime( $child->comment_date ) ); ?></span>
            </div>
        </div>
    <?php endforeach;?>
</div>