<?php
    /**
     * @var Type_6 $tab
     */
?>
<div class="accordion-mixed__content-inner">
    <div class="video-tab-row">
        <?php

            $mod = ((count($tab->getVideos()) > 3 or (count($tab->getVideos()) === 2)) and count($tab->getVideos()) % 2 === 0) ? 'video-tab-col_full-width' : '';
            foreach ($tab->getVideos() as $index => $video) :?>
                <div class="video-tab-col <?= (count($tab->getVideos()) === $index + 1) ? $mod : ''; ?>">
                    <div class="video-tab-wrapper">
                        <?= wp_oembed_get(esc_url($video['video'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
</div>
