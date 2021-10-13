<section class="b-container header-title">
    <h2 class="header-title__subtitle">Оставить отзыв</h2>
</section>
<style>
    .review-form__out{
        margin-top: 1rem;
    }

    .review-form__out-container{
        display: flex;
        margin-top: 1rem;
        align-items: center;
    }

    .review-form__out-item{
        padding: 10px 32px;
        color: #fff;
        background-color: #d0021b;
        border-radius: 4px;
        box-shadow: 0 2px 4px #4a4a4a;
        transition: all .4s;
        margin: 0 8px;
    }

    .review-form__submit:hover {
        background-color: #23c4f5;
    }

</style>
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
            <div class="review-form__out">
                Оставьте свой отзыв в:
                <div class="review-form__out-container">
                    <a class="review-form__out-item" href="https://www.google.com/search?q=%D0%B1%D0%B0%D0%B7%D0%B0+%D0%BE%D1%82%D0%B4%D1%8B%D1%85%D0%B0+%D0%BA%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D0%BA%D0%B0&rlz=1C5CHFA_enBY932BY932&biw=1440&bih=789&sxsrf=AOaemvLVgEwFxXsvpX_bwu1DacCicmG9LQ%3A1633850638747&ei=DpViYZCJLcXtsAeIrLlY&ved=0ahUKEwiQyMD3p7_zAhXFNuwKHQhWDgsQ4dUDCA4&uact=5&oq=%D0%B1%D0%B0%D0%B7%D0%B0+%D0%BE%D1%82%D0%B4%D1%8B%D1%85%D0%B0+%D0%BA%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D0%BA%D0%B0&gs_lcp=Cgdnd3Mtd2l6EAMyFwguEIAEEMcBEK8BEIsDEKYDEKgDEJMCMgUIABCABDoHCCMQsAMQJzoHCAAQRxCwAzoECCMQJzoUCC4QgAQQxwEQrwEQiwMQqAMQpgM6CwguEIAEEMcBEK8BOgYIABAHEB46BwgjELACECc6EwguEMcBEK8BEA0QiwMQpgMQqAM6BAgAEA06CgguEMcBEK8BEA06CAgAEAgQDRAeOhYILhDHARCvARANEIsDEKYDEKgDEJMCSgQIQRgAUMcnWKxRYL5UaARwAngAgAF3iAHvDJIBBDExLjaYAQCgAQHIAQq4AQPAAQE&sclient=gws-wiz#lrd=0x46c2e1254fde00c5:0xfda7b40d40fb64b1,1" target="_blank">Google</a>
                    <span>и</span>
                    <a class="review-form__out-item" href="https://yandex.by/search/?sk=ufdadeeb4d1b90a00055661b7910c0ae0&reqid=1633850822297351-14890081912965372777-vla1-3851-vla-l7-balancer-8080-BAL-7047&lr=157&text=%D0%91%D0%B0%D0%B7%D0%B0+%D0%BE%D1%82%D0%B4%D1%8B%D1%85%D0%B0+%D0%BD%D0%B0+%D0%91%D1%80%D0%B0%D1%81%D0%BB%D0%B0%D0%B2%D1%81%D0%BA%D0%B8%D1%85+%D0%BE%D0%B7%D0%B5%D1%80%D0%B0%D1%85+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D0%BA%D0%B0+%D0%91%D0%B5%D0%BB%D0%B0%D1%80%D1%83%D1%81%D1%8C%2C+%D0%92%D0%B8%D1%82%D0%B5%D0%B1%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%2C+%D0%91%D1%80%D0%B0%D1%81%D0%BB%D0%B0%D0%B2%D1%81%D0%BA%D0%B8%D0%B9+%D1%80%D0%B0%D0%B9%D0%BE%D0%BD%2C+%D0%9F%D0%BB%D1%8E%D1%81%D1%81%D0%BA%D0%B8%D0%B9+%D1%81%D0%B5%D0%BB%D1%8C%D1%81%D0%BE%D0%B2%D0%B5%D1%82%2C+%D0%B4%D0%B5%D1%80%D0%B5%D0%B2%D0%BD%D1%8F+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D0%BA%D0%B0&main-reqid=1633850822297351-14890081912965372777-vla1-3851-vla-l7-balancer-8080-BAL-7047&type=geov%2Cugc_db%2Cugcdb2%2Cugc_favorites%2Cugc_digest&drag_context=&oid=b%3A191151810278&_=1633850823785&source=wizgeo-common-new_explicit&noreask=1&ag_dynamic=%7B%22middle_yandex_travel_Date%22%3A%222021-10-11%22%2C%22middle_yandex_travel_Nights%22%3A1%2C%22middle_yandex_travel_Ages%22%3A%2288%2C88%22%7D&redircnt=1633850971.1" target="_blank">Yandex</a>
                </div>
            </div>
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