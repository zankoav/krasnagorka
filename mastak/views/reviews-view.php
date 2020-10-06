<?php
    $isCommentsPage = false;
    $number         = 16;
    $comments       = get_comments(array('post_id' => 9105, 'status' => 'approve', 'number' => $number));
    if (!is_home()) {
        echo '<noindex>';
    }

    if (count($comments) > 4 and false) :?>



        <section class="b-bgc-wrapper">
            <div class="b-container header-title">
                <p class="header-title__subtitle">Отзывы</p>
            </div>
            <div class="b-container reviews">

                <div class="swiper-container reviews__swiper">
                    <div class="swiper-wrapper reviews__wrapper">
                        <?php
                            foreach ($comments as $comment) {
                                get_template_part("mastak/views/comment", ($isCommentsPage ? "big" : "small"));
                            }
                        ?>
                    </div>
                    <div class="swiper-pagination reviews__pagination"></div>
                </div>
                <div class="swiper-button-next reviews__button-next"></div>
                <div class="swiper-button-prev reviews__button-prev"></div>

            </div>
        </section>
    <?php endif;

    if (!is_home()) {
        echo '</noindex>';
    }

