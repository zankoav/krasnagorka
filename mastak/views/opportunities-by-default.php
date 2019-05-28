<?php
	$scopes = get_option( 'mastak_opportunities_appearance_options' )['scope'];
    $image_size = 'icon-64';

?>
<section class="opportunities-section">
    <div class="b-container basic-opportunities">
        <div class="basic-opportunities__wrapper">
			<?php foreach ( $scopes as $scope ): ?>
                <div class="basic-opportunities__item">
                    <img class="basic-opportunities__image" alt="<?=$scope["item_name"]?>"
                         src="<?= wp_get_attachment_image_url( $scope["item_icon_id"], $image_size ) ?>"
                         srcset="<?= wp_get_attachment_image_srcset( $scope["item_icon_id"], $image_size ) ?>"
                         sizes="<?= wp_get_attachment_image_sizes(  $scope["item_icon_id"], $image_size ) ?>">
                    <p class="basic-opportunities__text"><?=$scope["item_name"]?></p>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
</section>