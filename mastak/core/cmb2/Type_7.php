<?php

	class Type_7 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_7_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
		}

		public function getId(){
			return $this->id;
		}

		public function getItems() {
			$icons  = $this->mastak_event_tab_type_7_items;
			$items = null;

			if ( is_serialized( $icons ) ) {
				$items = unserialize( $icons );
			}

			return $items;
		}
	}