<?php
    /**
     * @var Type_6 $tab
     */
?>
<div class="accordion-mixed__content-inner">
    <div class="video-tab-row">
        <?php

            $videos = (array) $tab->getVideos();
            $mod = ((count($videos) > 3 or (count($videos) === 2)) and count($videos) % 2 === 0) ? 'video-tab-col_full-width' : '';
            foreach ($videos as $index => $video) :
                $video_file = !empty($video['video_file']) ? $video['video_file'] : '';
                $desktop_width = !empty($video['desktop_width']) ? (int) $video['desktop_width'] : 100;
                $desktop_width = min(100, max(1, $desktop_width));
                $wrapper_id = 'vide-' . $tab->getId() . '-' . $index;
                ?>
                <div class="video-tab-col <?= (count($videos) === $index + 1) ? $mod : ''; ?>">
                    <style>
                        #<?= esc_attr($wrapper_id); ?> {
                            width: 100%;
                            margin-left: auto;
                            margin-right: auto;
                        }

                        @media (min-width: 768px) {
                            #<?= esc_attr($wrapper_id); ?> {
                                max-width: <?= $desktop_width; ?>%;
                            }
                        }
                    </style>
                    <div id="<?= esc_attr($wrapper_id); ?>" class="video-tab-wrapper<?= $video_file ? ' video-tab-wrapper--file' : ''; ?>"<?= $video_file ? ' style="padding-top:0;"' : ''; ?>>
                        <?php if ($video_file) : ?>
                            <video controls preload="metadata" style="display:block;width:100%;height:auto;">
                                <source src="<?= esc_url($video_file); ?>" type="video/mp4">
                                Ваш браузер не поддерживает воспроизведение видео.
                            </video>
                        <?php elseif (!empty($video['video'])) : ?>
                            <script>
                                setTimeout(function () {
                                    jQuery('#<?= esc_js($wrapper_id); ?>').append('<iframe src="https://www.youtube.com/embed/<?= esc_js($video['video']); ?>" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>');
                                }, 3000);
                            </script>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
</div>
