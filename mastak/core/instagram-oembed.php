<?php

if (!defined('ABSPATH')) {
    exit;
}

function mastak_enqueue_instagram_embed_script()
{
    static $enqueued = false;

    if ($enqueued) {
        return;
    }

    $enqueued = true;
    wp_enqueue_script('mastak-instagram-embed', 'https://www.instagram.com/embed.js', array(), null, true);
    wp_add_inline_script('mastak-instagram-embed', <<<'JS'
(function () {
    function resizeInstagramEmbed(frame) {
        var height = parseInt(frame.getAttribute('height'), 10);

        frame.style.setProperty('position', 'relative', 'important');

        if (height) {
            frame.style.setProperty('height', height + 'px', 'important');
        }
    }

    function resizeAllInstagramEmbeds() {
        document.querySelectorAll('.video-tab-wrapper--instagram iframe').forEach(resizeInstagramEmbed);
    }

    resizeAllInstagramEmbeds();

    new MutationObserver(resizeAllInstagramEmbeds).observe(document.body, {
        attributes: true,
        childList: true,
        subtree: true,
        attributeFilter: ['height']
    });
}());
JS
    , 'after');
}

/**
 * Gets Instagram embed HTML through Meta's oEmbed endpoint.
 * A token is optional; successful responses are cached.
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

    $cache_key = 'mastak_instagram_oembed_' . md5($url);
    $cached_html = get_transient($cache_key);

    if (false !== $cached_html) {
        mastak_enqueue_instagram_embed_script();

        return $cached_html;
    }

    $endpoint = apply_filters(
        'mastak_instagram_oembed_endpoint',
        'https://graph.facebook.com/v26.0/instagram_oembed'
    );
    $request_args = array(
        'url'          => $url,
        'omitscript'   => 'true',
    );

    if ($access_token) {
        $request_args['access_token'] = $access_token;
    }

    $response = wp_safe_remote_get(add_query_arg($request_args, $endpoint), array(
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
    mastak_enqueue_instagram_embed_script();

    return $html;
}
