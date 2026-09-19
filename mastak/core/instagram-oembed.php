<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Gets Instagram embed HTML through the authenticated Meta oEmbed endpoint.
 * The access token stays on the server; successful responses are cached.
 *
 * @param string $url Instagram post, Reel, or TV URL.
 * @return string Embed HTML, or an empty string when it cannot be embedded.
 */
function mastak_get_instagram_oembed($url)
{
    $url = esc_url_raw($url);
    $parts = wp_parse_url($url);
    $host = !empty($parts['host']) ? strtolower($parts['host']) : '';

    if (!in_array($host, array('instagram.com', 'www.instagram.com'), true)) {
        return '';
    }

    $options = get_option('mastak_theme_options', array());
    $access_token = !empty($options['mastak_theme_options_instagram_oembed_token'])
        ? trim($options['mastak_theme_options_instagram_oembed_token'])
        : '';

    if (!$access_token) {
        return '';
    }

    $cache_key = 'mastak_instagram_oembed_' . md5($url);
    $cached_html = get_transient($cache_key);

    if (false !== $cached_html) {
        wp_enqueue_script('mastak-instagram-embed', 'https://www.instagram.com/embed.js', array(), null, true);

        return $cached_html;
    }

    $endpoint = apply_filters(
        'mastak_instagram_oembed_endpoint',
        'https://graph.facebook.com/v22.0/instagram_oembed'
    );
    $response = wp_safe_remote_get(add_query_arg(array(
        'url'          => $url,
        'access_token' => $access_token,
        'omitscript'   => 'true',
    ), $endpoint), array(
        'timeout' => 10,
    ));

    if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
        return '';
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    $html = !empty($data['html']) ? $data['html'] : '';

    if (!$html) {
        return '';
    }

    set_transient($cache_key, $html, 12 * HOUR_IN_SECONDS);
    wp_enqueue_script('mastak-instagram-embed', 'https://www.instagram.com/embed.js', array(), null, true);

    return $html;
}
