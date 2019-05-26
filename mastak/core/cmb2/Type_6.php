<?php

	class Type_6 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_6_videos;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
		}

		public function getId(){
			return $this->id;
		}

		public function getVideos() {
			$icons  = $this->mastak_event_tab_type_6_videos;
			$videos = null;

			if ( is_serialized( $icons ) ) {
				$videos = unserialize( $icons );
			}

			return $videos;
		}
	}
