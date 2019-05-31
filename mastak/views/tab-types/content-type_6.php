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
                    <div id="vide-<?= $index?>" class="video-tab-wrapper">
                        <script>
                            setTimeout(function () {
                                jQuery('#vide-<?= $index?>').append('<iframe src="https://www.youtube.com/embed/<?= $video['video']; ?>" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>');
                            }, 3000);
                        </script>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
</div>
