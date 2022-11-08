<?php
    use Ls\Wp\Log as Log;

	class Type_10 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_10_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
		}

		public function getId(){
			return $this->id;
		}

		public function getItems() {
			$icons  = $this->mastak_event_tab_type_10_items;
			$items = null;

			if ( is_serialized( $icons ) ) {
				$items = unserialize( $icons );
			}

            $items = $this->initHouses($items);
			return $items;
		}

        private function initHouses($items){
            foreach($items as &$item){
                $item['house'] = $this->getHouseIdByCalendarId($item['calendar']);
            }
            return $items;
        }

        private function getHouseIdByCalendarId($calendarId){
            $result = 0;
            $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1);

            $houseQuery = new WP_Query;
            $args = null;
            if($isTeremRoom){
                $args = array(
                    'post_type' => 'house',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key'     => 'mastak_house_is_it_terem',
                            'value'   =>  'on',
                            'compare' => '=',
                        )
                    )
                );
            }else{
                $args = array(
                    'post_type' => 'house',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key'     => 'mastak_house_calendar',
                            'value'   =>  'id="' . $calendarId . '"',
                            'compare' => 'LIKE',
                        )
                    )
                );
            }
            $houses = $houseQuery->query($args);
            if(count($houses)){
               return  $houses[0]->ID;
            }else{
                return  null;
            }
        }

	}