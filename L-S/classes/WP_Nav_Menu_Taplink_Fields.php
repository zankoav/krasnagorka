<?php
// https://wp-kama.ru/id_15476/dopolnitelnye-polya-dlya-wp_nav_menu.html
final class WP_Nav_Menu_Taplink_Fields
{

    public static array $field_keys = [

        'test_color_field' => [
            'title' => 'Цвет фона кнопки',
            'type' => 'color',
            'size' => 'thin', // thin | wide
            // 'desc' => 'some text',
        ]

    ];

    public static function init(): void
    {

        if (is_admin()) {
            add_action('wp_nav_menu_item_custom_fields', [__CLASS__, 'add_fileds'], 10, 2);
            add_action('wp_update_nav_menu_item', [__CLASS__, 'save_fields'], 10, 2);
        }
    }

    public static function add_fileds($item_id, $item)
    {

        foreach (self::$field_keys as $meta_key => $data) {

            $value = get_post_meta($item_id, $meta_key, true);
            $title = $data['title'];
            $type = $data['type'] ?? 'text';
            $size = $data['size'] ?? 'wide';

            $desc = empty($data['desc']) ? '' : '<span class="description">' . $data['desc'] . '</span>';
?>
            <p class="field-<?= $meta_key ?> description description-<?= $size ?>">
                <?= $title ?>
                <br />
                <input class="widefat edit-menu-item-<?= $meta_key ?>" type="<?= $type ?>" name="<?= sprintf('%s[%s]', $meta_key, $item_id) ?>" id="menu-item-<?= $item_id ?>" value="<?= esc_attr($value) ?>" />

                <?= $desc ?>
            </p>
<?php
        }
    }

    public static function save_fields($menu_id, $item_id)
    {

        foreach (self::$field_keys as $meta_key => $data) {
            self::save_field($menu_id, $item_id, $meta_key);
        }
    }

    private static function save_field($menu_id, $item_id, $meta_key)
    {

        if (!isset($_POST[$meta_key][$item_id])) {
            return;
        }

        $val = $_POST[$meta_key][$item_id];

        if ($val) {
            update_post_meta($item_id, $meta_key, sanitize_text_field($val));
        } else {
            delete_post_meta($item_id, $meta_key);
        }
    }
}
