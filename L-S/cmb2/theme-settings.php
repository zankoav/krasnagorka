<?php

use Cmb2Grid\Grid\Cmb2Grid;

if (!defined('ABSPATH')) { exit; }

add_action('cmb2_admin_init', function () {

    $logoUrl = 'dashicons-palmtree';
    $logoOptions = get_option('mastak_theme_options');
    
    if(isset($logoOptions, $logoOptions['footer_logo_id'])){
        $logoUrl = wp_get_attachment_image_src($logoOptions['footer_logo_id'], 'icon-menu')[0];
    }
  
    $cmb_options = new_cmb2_box(array(
        'id'           => 'mastak_theme_options_page',
        'title'        => esc_html__('НAСТРОЙКИ ТЕМЫ KRASNAGORKA', 'krasnagorka'),
        'object_types' => array('options-page'),
        'option_key' => 'mastak_theme_options',
        'icon_url'   =>  $logoUrl,
        'menu_title'      => 'Красногорка'
    ));

    $cmb_options->add_field(array(
        'name' => __('Выберите Сезон', 'krasnagorka'),
        'id'   => 'season_title',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name'             => 'Текущий сезон',
        'id'               => 'current_season',
        'type'             => 'select',
        'show_option_none' => true,
        'default'          => 'custom',
        'options_cb'       => 'show_seasons_options',
        'attributes'     => array(
            'readonly' => 'readonly'
        )
    ));


    $cmb_options->add_field(array(
        'name' => __('Телефоны', 'krasnagorka'),
        'id'   => 'phones_title',
        'type' => 'title'
    ));

    $a1 = $cmb_options->add_field(array(
        'desc' => __('A1', 'krasnagorka'),
        'id'   => 'mastak_theme_options_a1',
        'type' => 'text'
    ));

    $mts = $cmb_options->add_field(array(
        'desc' => __('Мтс', 'krasnagorka'),
        'id'   => 'mastak_theme_options_mts',
        'type' => 'text'
    ));

    $life = $cmb_options->add_field(array(
        'desc' => __('Лайф', 'krasnagorka'),
        'id'   => 'mastak_theme_options_life',
        'type' => 'text'
    ));



    $cmb2Grid = new Cmb2Grid($cmb_options);
    $rowPhones = $cmb2Grid->addRow();
    $rowPhones->addColumns(array($a1,$mts,$life));

    $cmb_options->add_field(array(
        'name' => __('Социальные сети', 'krasnagorka'),
        'id'   => 'socials_title',
        'type' => 'title'
    ));

    $insta = $cmb_options->add_field(array(
        'desc' => 'Instagram (url)',
        'id'   => 'mastak_theme_options_instagram',
        'type' => 'text_url'
    ));

    $tiktok = $cmb_options->add_field(array(
        'desc' => 'TikTok (url)',
        'id'   => 'mastak_theme_options_tiktok',
        'type' => 'text_url'
    ));

    $fb = $cmb_options->add_field(array(
        'desc' => 'Facebook (url)',
        'id'   => 'mastak_theme_options_facebook',
        'type' => 'text_url'
    ));

    $ok = $cmb_options->add_field(array(
        'desc' => 'Odnoklassniki (url)',
        'id'   => 'mastak_theme_options_odnoklassniki',
        'type' => 'text_url'
    ));

    $vk = $cmb_options->add_field(array(
        'desc' => 'VK (url)',
        'id'   => 'mastak_theme_options_vkontakte',
        'type' => 'text_url'
    ));

    $youtube = $cmb_options->add_field(array(
        'desc' => 'Youtube (url)',
        'id'   => 'mastak_theme_options_youtube',
        'type' => 'text_url'
    ));

    $telegram = $cmb_options->add_field(array(
        'desc' => 'Telegram (url)',
        'id'   => 'mastak_theme_options_telegram',
        'type' => 'text_url'
    ));

    $cmb2Grid = new Cmb2Grid($cmb_options);
    $rowSocial_1 = $cmb2Grid->addRow();
    $rowSocial_1->addColumns(array($insta,$fb,$ok));
    $rowSocial_2 = $cmb2Grid->addRow();
    $rowSocial_2->addColumns(array($vk,$youtube,$telegram));
    $rowSocial_3 = $cmb2Grid->addRow();
    $rowSocial_3->addColumns(array($tiktok));
   


    $cmb_options->add_field(array(
        'name' => __('Контактная информация', 'krasnagorka'),
        'id'   => 'contacts_title',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name' => __('Видео online', 'krasnagorka'),
        'desc' => __('Видео online', 'krasnagorka'),
        'id'   => 'mastak_theme_options_video',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name' => __('Email', 'krasnagorka'),
        'desc' => __('Электронный адрес', 'krasnagorka'),
        'id'   => 'mastak_theme_options_email',
        'type' => 'text_email'
    ));

    $cmb_options->add_field(array(
        'name' => __('Email комментариев', 'krasnagorka'),
        'desc' => __('При добавлении комментария сюда будет приходить оповещение', 'krasnagorka'),
        'id'   => 'mastak_theme_options_comment_email',
        'type' => 'text_email'
    ));

    $cmb_options->add_field(array(
        'name' => __('Доп. Email комментариев', 'krasnagorka'),
        'desc' => __('При добавлении комментария сюда будет приходить оповещение', 'krasnagorka'),
        'id'   => 'mastak_theme_options_comment_email_2',
        'type' => 'text_email'
    ));


    $cmb_options->add_field(array(
        'name' => __('Address', 'krasnagorka'),
        'desc' => __('Адерес компании', 'krasnagorka'),
        'id'   => 'mastak_theme_options_address',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => __('Координаты', 'krasnagorka'),
        'desc' => __('Координаты компании', 'krasnagorka'),
        'id'   => 'mastak_theme_options_coordinate',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => __('Время работы', 'krasnagorka'),
        'desc' => __('Время работы (8:00-23:00)', 'krasnagorka'),
        'id'   => 'mastak_theme_options_time',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => __('Выходные', 'krasnagorka'),
        'desc' => __('Выходные (без выходных)', 'krasnagorka'),
        'id'   => 'mastak_theme_options_weekend',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => __('Как доехать?', 'krasnagorka'),
        'desc' => __('Как доехать? (url)', 'krasnagorka'),
        'id'   => 'mastak_theme_options_location',
        'type' => 'text_url'
    ));

    $cmb_options->add_field(array(
        'name' => __('Как забронировать?', 'krasnagorka'),
        'desc' => __('Как забронировать? (url)', 'krasnagorka'),
        'id'   => 'mastak_theme_options_booking',
        'type' => 'text_url'
    ));

    $cmb_options->add_field(array(
        'name' => __('Популярные вопросы', 'krasnagorka'),
        'desc' => __('Популярные вопросы FAQ (url)', 'krasnagorka'),
        'id'   => 'mastak_theme_options_faq',
        'type' => 'text_url'
    ));



    $cmb_options->add_field(array(
        'name' => 'Схема базы домов',
        'id'   => 'mastak_theme_options_schema',
        'type' => 'file'
    ));

    $cmb_options->add_field(array(
        'name' => 'Схема базы услуг',
        'id'   => 'mastak_theme_options_schema_2',
        'type' => 'file'
    ));

    $cmb_options->add_field(array(
        'name' => 'Способы оплаты',
        'desc' => 'Способы оплаты',
        'id'   => 'mastak_theme_options_paymants',
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        // 'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        'text' => array(
            'add_upload_files_text' => 'Добавит или загрузить логотип', // default: "Add or Upload Files"
            'remove_image_text'     => 'Удалить логотип', // default: "Remove Image"
            'file_text'             => 'Файл', // default: "File:"
            'file_download_text'    => 'Загрузить', // default: "Download"
            'remove_text'           => 'Удалить', // default: "Remove"
        ),
    ));

    $cmb_options->add_field(array(
        'name' => 'УНП',
        'desc' => 'УНП (optional)',
        'id'   => 'mastak_theme_options_unp',
        'type' => 'textarea_code'
    ));

    
    $cmb_options->add_field(array(
        'name' => __('Скрыть звезды в комментариях', 'krasnagorka'),
        'id'   => 'mastak_theme_options_hide_stars',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name'            => 'Скорость слайдера отзывов',
        'id'              => 'mastak_theme_options_slider_delay',
        'description'     => __('В милисекундах (2000 = 2 сек)', 'krasnagorka'),
        'type'            => 'text',
        'attributes'      => array(
            'type'    => 'number',
            'pattern' => '\d*',
        ),
        'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint',
    ));

    $cmb_options->add_field(array(
        'name' => 'Страница 404',
        'id'   => 'title-404',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name' => 'Заголовок страницы',
        'id'   => 'title_404',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Подзаголовок страницы',
        'id'   => 'sub_title_404',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Картинка',
        'id'   => 'bgimage_404',
        'type' => 'file'
    ));

    $cmb_options->add_field(array(
        'name' => 'Логотип в подвале',
        'id'   => 'footer_logo',
        'type' => 'file',
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'preview_size' => array( 100, 100 ),
    ));


    $cmb_options->add_field(array(
        'name' => __('Рекламный баннер в хлебных крошках', 'krasnagorka'),
        'id'   => 'breadcrumb_banner',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name' => 'Включить баннер?',
        'id'   => 'breadcrumb_banner_is_open',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name' => 'Своя иконка',
        'description' => 'Рекомендованно формат SVG, PNG',
        'id'   => 'breadcrumb_banner_img',
        'type' => 'file'
    ));

    $cmb_options->add_field(array(
        'name' => 'Иконка баннера',
        'description' => 'Рекомендованно формат SVG, PNG',
        'id'   => 'breadcrumb_banner_img_default',
        'type'    => 'select',
        'default' => '1',
        'options' => array(
            '1'  => __('Сердце 1', 'krasnagorka'),
            '2' => __('Подарок', 'krasnagorka'),
            '3' => __('Вишенка', 'krasnagorka'),
            '4' => __('Клубника', 'krasnagorka'),
            '5' => __('Кусок торта', 'krasnagorka'),
            '6' => __('Летящая звезда', 'krasnagorka'),
            '7' => __('Колокольчик', 'krasnagorka'),
            '8' => __('Оазис', 'krasnagorka'),
            '9' => __('Пламя', 'krasnagorka'),
            '10' => __('Звезда', 'krasnagorka'),
            '11' => __('Сердце 2', 'krasnagorka'),
            '12' => __('Ракета', 'krasnagorka'),
            '13' => __('Новогодняя ель', 'krasnagorka'),
            '14' => __('Кофети', 'krasnagorka'),
        ),

    ));

    $cmb_options->add_field(array(
        'name' => 'Текст баннера',
        'id'   => 'breadcrumb_banner_text',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Ссылка',
        'id'   => 'breadcrumb_banner_link',
        'type' => 'text_url'
    ));

    $cmb_options->add_field(array(
        'name' => 'Открывать в новом окне?',
        'id'   => 'breadcrumb_banner_is_target',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name'            => 'Задержка анимации',
        'id'              => 'breadcrumb_banner_animation_delay',
        'description'     => __('В милисекундах (1с = 1000мс)', 'krasnagorka'),
        'type'            => 'text',
        'attributes'      => array(
            'type'    => 'number',
            'pattern' => '\d*'
        ),
        'sanitization_cb' => 'absint',
        'escape_cb'       => 'absint'
    ));

    $cmb_options->add_field(array(
        'name'    => __('Тип анимации', 'krasnagorka'),
        'desc'    => __('Выберите тип анимации', 'krasnagorka'),
        'id'      => 'breadcrumb_banner_animation_type',
        'type'    => 'select',
        'default' => 'fade',
        'options' => array(
            'fade'  => __('Плавное появление', 'krasnagorka'),
            'fade_blink_infinity' => __('Плавное появление и мерцание тексата', 'krasnagorka'),
            'fade_puls_icon_only' => __('Плавное появление и пульсация иконки', 'krasnagorka'),
            'fade_puls_icon' => __('Плавное появление и пульсация иконки c поворотом', 'krasnagorka'),

        ),
    ));

    $cmb_options->add_field(array(
        'name' => __('Настройки календаря', 'krasnagorka'),
        'id'   => 'calendar_settings_title',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name' => 'Текст заголовка помощи',
        'id'   => 'calendar_settings_message_before',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Текст заголовка помощи до выделении дат бронирования',
        'id'   => 'calendar_settings_message',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Текст заголовка после выделения дат бронирования',
        'id'   => 'calendar_settings_message_after',
        'type' => 'textarea_small'
    ));

    $cmb_options->add_field(array(
        'name' => 'Договор присоединения',
        'id'   => 'contract_offer',
        'type' => 'file'
    ));

    $cmb_options->add_field(array(
        'name' => 'Памятка гостя',
        'id'   => 'guest_memo',
        'type' => 'file'
    ));


    $cmb_options->add_field(array(
        'name' => __('Настройки Альфа-Банк API', 'krasnagorka'),
        'id'   => 'alpha_bank_settings_title',
        'type' => 'title'
    ));

    $cmb_options->add_field(array(
        'name' => 'Включить Alpha Bank оплату',
        'id'   => 'alpha_bank_settings_enabled',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name' => 'Включить PROD',
        'id'   => 'alpha_bank_settings_production_enabled',
        'type' => 'checkbox'
    ));

    $cmb_options->add_field(array(
        'name' => 'Username PROD',
        'id'   => 'alpha_bank_settings_username_prod',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => 'Password PROD',
        'id'   => 'alpha_bank_settings_password_prod',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => 'Username SANDBOX',
        'id'   => 'alpha_bank_settings_username_sandbox',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => 'Password SANDBOX',
        'id'   => 'alpha_bank_settings_password_sandbox',
        'type' => 'text'
    ));

    $cmb_options->add_field(array(
        'name' => 'Url для возврата',
        'id'   => 'alpha_bank_settings_return_url',
        'type' => 'text_url'
    ));

});
