<?php 
	$options = get_option('mastak_home_appearance_options');

	$need_more_title = $options['mastak_home_need_more_title'];
    $need_more_description = $options['mastak_home_need_more_description'];
    $need_more_link_title = $options['mastak_home_need_more_link_title'];
    $need_more_link = $options['mastak_home_need_more_link'];
	$need_more_img = $options['mastak_home_need_more_img'];


?>

<div class="b-container more-questions">
	<style>
		.banner-house {
			background-color: #fff;
		}

		@media (min-width:1024px) {
			.banner-house {
				display: flex;
				flex-direction: row-reverse;
				border-radius: 8px;
				overflow: hidden;
			}
		}

		.banner-house__img {
			display: flex;
			height: 104px;
			width: 100%;
			object-fit: cover;
		}

		@media (min-width:1024px) {
			.banner-house__img {
				height: 230px;
				width: 50%;
			}
		}

		.banner-house__text {
			color: #4A4A4A;
			text-align: center;
			padding: 16px 8px 24px;
		}

		@media (min-width:1024px) {
			.banner-house__text {
				display: flex;
				flex-direction: column;
				width: 50%;
				align-items: center;
				justify-content: center;
				padding: 0;
			}
		}



		.banner-house__text-title {
			font-size: 24px;
		}

		@media (min-width:1024px) {
			.banner-house__text-title {
				font-size: 30px;
			}
		}

		.banner-house__text-info {
			font-size: 14px;
			margin-top: 8px;
			line-height: 1.4;
		}

		@media (min-width:1024px) {
			.banner-house__text-info {
				font-size: 16px;
				margin-top: 16px;
			}
		}

		.banner-house__button {
			display: inline-block;
			font-size: 14px;
			margin-top: 16px;
			background-color: #E01515;
			border-radius: 8px;
			color: #fff;
			padding: .75rem 3rem;
			text-decoration: none;
		}
	</style>
	<div class="banner-house">
		<img class="banner-house__img"
				src="<?=$need_more_img?>">
		<div class="banner-house__text">
			<div class="banner-house__text-title"><?=$need_more_title?></div>
			<div class="banner-house__text-info"><?=$need_more_description?></div>
			<a class="banner-house__button"
				href="<?=$need_more_link?>"><?=$need_more_link_title?></a>
		</div>
	</div>
</div>