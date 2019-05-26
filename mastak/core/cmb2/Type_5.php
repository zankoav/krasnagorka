<?php

	class Type_5 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_5_slides;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
		}

		public function getId(){
			return $this->id;
		}

		public function getEvents() {
			$icons  = $this->mastak_event_tab_type_5_slides;
			$events = null;

			if ( is_serialized( $icons ) ) {
				$events = unserialize( $icons );
			}

			return $events;
		}
	}