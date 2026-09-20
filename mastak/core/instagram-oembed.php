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
    $url = preg_replace('#^(https?://(?:www\.)?instagram\.com)/reels/#i', '$1/reel/', $url);
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

/**
 * Converts a public video URL into embed HTML, with fallbacks for Instagram
 * and YouTube when the generic WordPress oEmbed request is unavailable.
 *
 * @param string $url Video URL.
 * @return string Embed HTML, or an empty string.
 */
function mastak_get_video_embed_html($url)
{
    $url = esc_url_raw(trim((string) $url));
    $url = preg_replace('#^(https?://(?:www\.)?instagram\.com)/reels/#i', '$1/reel/', $url);

    if (!$url) {
        return '';
    }

    $parts = wp_parse_url($url);
    $host = !empty($parts['host']) ? strtolower($parts['host']) : '';

    if (in_array($host, array('instagram.com', 'www.instagram.com'), true)) {
        return mastak_get_instagram_oembed($url);
    }

    $embed_html = wp_oembed_get($url);

    if ($embed_html) {
        return $embed_html;
    }

    $video_id = '';

    if (in_array($host, array('youtu.be', 'www.youtu.be'), true)) {
        $video_id = trim($parts['path'] ?? '', '/');
    } elseif (in_array($host, array('youtube.com', 'www.youtube.com', 'm.youtube.com'), true)) {
        parse_str($parts['query'] ?? '', $query);
        $video_id = $query['v'] ?? '';
    }

    if (!preg_match('/^[A-Za-z0-9_-]{11}$/', $video_id)) {
        return '';
    }

    return sprintf(
        '<iframe src="https://www.youtube-nocookie.com/embed/%s" title="YouTube video player" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
        esc_attr($video_id)
    );
}
