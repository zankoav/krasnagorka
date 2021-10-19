<?php
if (!defined('ABSPATH')) { exit; }

add_action( 'widgets_init', function () {
    register_sidebar( array(
        'name'          => 'Акции текстовая область',
        'id'            => 'events-content',
        'before_widget' => '<section class="b-container big-text">
                                <div class="big-text__container content-text">',
        'after_widget'  => '</div>
                                <div class="show-more">
                                    <div class="show-more__button">
                                        <div class="show-more__dote"></div>
                                        <div class="show-more__dote"></div>
                                        <div class="show-more__dote"></div>
                                    </div>
                                    <span class="show-more__title">Показать еще</span>
                                </div>
                            </section>',
        'before_title'  => '<section class="header-title">
                                <h2 class="header-title__subtitle">',
        'after_title'   => '</h2></section>',
    ) );
});