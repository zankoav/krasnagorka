<?php
	$scopes = get_option( 'mastak_opportunities_appearance_options' )['scope'];
?>
<section class="opportunities-section">
    <div class="b-container basic-opportunities">
        <div class="basic-opportunities__wrapper">
			<?php foreach ( $scopes as $scope ): ?>
                <div class="basic-opportunities__item">
                    <img class="basic-opportunities__image" src="<?=$scope["item_icon"]?>"
                         alt="<?=$scope["item_name"]?>">
                    <p class="basic-opportunities__text"><?=$scope["item_name"]?></p>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
</section>