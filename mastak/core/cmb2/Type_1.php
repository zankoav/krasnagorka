<?php

	class Type_1 extends BaseMeta {

		public $mastak_event_tab_type_1_title;
		public $mastak_event_tab_type_1_description;
		public $mastak_event_tab_type_1_image;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
		}

		public function getTitle() {
			return $this->mastak_event_tab_type_1_title;
		}

		public function getImage() {
			return $this->mastak_event_tab_type_1_image;
		}

		public function getDescription() {
			return $this->mastak_event_tab_type_1_description;
		}

		public function getLists() {
			$icons = $this->mastak_event_tab_type_1_icons;
			$items = null;

			if ( is_serialized( $icons ) ) {
				$items = unserialize( $icons );
			}

			return $items;
		}
	}