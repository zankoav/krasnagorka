<?php

	class Type_2 extends BaseMeta {

		public $mastak_event_tab_type_2_gallery;
		public $tab_id;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->tab_id = $tab_id;
		}

		public function viewGallary( $img_size = 'medium' ) {
			$items = $this->mastak_event_tab_type_2_gallery;
			$files = null;
			if ( is_serialized( $items ) ) {
				$files = unserialize( $items );
			}
//			 Get the list of files
			foreach ( (array) $files as $attachment_id => $attachment_url ) : ?>
                <div class="swiper-slide house-media-library__item">
                    <a rel="group" href="<?= $attachment_url; ?>"
                       class="house-media-library__media-wrapper">
						<?= wp_get_attachment_image( $attachment_id, $img_size, false, array( 'class' => 'house-media-library__media' ) ); ?>
                    </a>
                </div>
			<?php endforeach;
		}
	}