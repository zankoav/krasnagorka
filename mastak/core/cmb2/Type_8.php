<?php
    use Ls\Wp\Log as Log;

	class Type_8 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_8_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
            Log::info('1', 'ok');
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

            $this->initHouses($items);

			return $items;
		}

        private function initHouses($items){
            Log::info('2', 'ok');
        }

	}