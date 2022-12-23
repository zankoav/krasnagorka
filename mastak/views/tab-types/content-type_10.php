<?php
    /**
     * @var Type_10 $tab
     * @var Assets $assets
     */
    global $assets;
?>
<div class="accordion-mixed__content-inner" data-event-tab=<?=$tab->id?> data-event=<?=get_the_ID()?>>
    <script src="<?= $assets->js('tab_events'); ?>"></script>
</div>

