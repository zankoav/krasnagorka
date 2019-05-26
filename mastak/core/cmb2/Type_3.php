<?php

	class Type_3 extends BaseMeta {

		public $mastak_event_tab_type_3_gallery;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
		}

		public function viewGallary( $img_size = 'medium' ) {
			$items = $this->mastak_event_tab_type_3_gallery;
			$files = null;
			if ( is_serialized( $items ) ) {
				$files = unserialize( $items );
			}
//			 Get the list of files
			foreach ( (array) $files as $attachment_id => $attachment_url ) : ?>
					<img src="<?= $attachment_url; ?>" alt="img" class="full-width mb-20">
			<?php endforeach;
		}
	}