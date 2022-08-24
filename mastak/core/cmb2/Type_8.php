<?php
    use Ls\Wp\Log as Log;

	class Type_8 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_8_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
            $this->house = $this->getHouseId();
		}

		public function getId(){
			return $this->id;
		}

		public function getItems() {
			$icons  = $this->mastak_event_tab_type_8_items;
			$items = null;

			if ( is_serialized( $icons ) ) {
				$items = unserialize( $icons );
			}

			return $items;
		}

        private function getHouseId(){
            $id = $this->house;
            Log::info('calendar', $this->calendar);

            
            return $id;
        }

	}