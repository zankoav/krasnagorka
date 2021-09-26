<?php
    if (!defined('ABSPATH')) {
        exit;
    }
    $source = $_GET['source'];

?>
<?php if(!empty($source)):?>
    <p>Source: <?=$source?></p>
<?php endif;?>