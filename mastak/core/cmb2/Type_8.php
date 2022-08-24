<?php
    use Ls\Wp\Log as Log;

	class Type_8 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_8_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
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
            foreach($items as $item){
                $house = $this->getHouseIdByCalendarId($item['calendar']);
                // $item['house'] = $this->getHouseIdByCalendarId($item['calendar']);
                Log::info('initHouses', $house);
            }
        }

        private function getHouseIdByCalendarId($calendarId){
            $result = 0;
            return $result;
        }

	}