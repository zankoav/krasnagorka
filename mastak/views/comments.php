<section class="b-container header-title">
    <h2 class="header-title__subtitle">Оставить отзыв</h2>
</section>
<div class="b-container">
    <div class="review-form review-form_form_grey">
        <div class="review-form__content">
            <?php
                $args = array(
                    'comment_field'      => '<div class="review-form__item"><label for="review-form-review">Отзыв</label> <textarea id="review-form-review" name="comment" cols="90" rows="6" class="review-form__textarea b-p-25"  aria-required="true" required="required"></textarea></div>',
                    'label_submit'       => 'Отправить',
                    'class_submit'       => 'review-form__submit',
                    'title_reply_before' => '',
                    'title_reply_after'  => '',
                    'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
                    'submit_field'       => '<div class="review-form__item review-form__item_position_center">%1$s %2$s</div>',
                );
                comment_form($args, $post_id = null);
            ?>
        </div>
    </div>
</div>


<?php
    $isCommentsPage = true;
    $number         = 20;

    $comments = get_comments(array(
        'post_id'      => 9105,
        'status'       => 'approve',
        'number'       => $number,
        'hierarchical' => 'threaded'
    ));
?>

<section class="b-container header-title">
    <p class="header-title__subtitle">Отзывы</p>
</section>

<div class="b-container js-comments">
    <?php
        foreach ($comments as $comment) {
            get_template_part("mastak/views/comment", ($isCommentsPage ? "big" : "small"));
        }
    ?>
</div>

<div class="show-more show-more--opportunities b-my-2">
    <div class="show-more__button">
        <div class="show-more__dote"></div>
        <div class="show-more__dote"></div>
        <div class="show-more__dote"></div>
    </div>
    <span class="show-more__title">Показать еще</span>
</div>