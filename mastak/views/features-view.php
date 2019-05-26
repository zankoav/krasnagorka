<?php
	$portfolio_features = get_option( 'mastak_home_appearance_options' )['portfolio_features'];

?>
<div class="b-container">
	<div class="features">
		<?php foreach ( $portfolio_features as $feature ): ?>
			<div class="features__item">
				<div class="feature">
					<img class="feature__image" src="<?= $feature["feature_icon"]; ?>"
					     alt="Уникальная природная зона"
					     title="Уникальная природная зона">
					<p class="feature__description"><?= $feature["feature_name"]; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>