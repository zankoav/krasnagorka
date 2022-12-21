<?php
    use Ls\Wp\Log as Log;
    use LsFactory\VariantFactory as VariantFactory; 

	class Type_10 extends BaseMeta {

		public $id;
		public $mastak_event_tab_type_10_items;

		public function __construct( $tab_id ) {
			parent::__construct( $tab_id );
			$this->id = $tab_id;
		}

        public function getData(){
            $variantByDefault = get_post_meta($this->id, 'mastak_event_tab_type_10_variant_by_default', 1);
            $items = $this->getItems();
            $calendars = [];
            foreach($items as $item){
                $calendars[] = [
                    'calendar' => intval($item['calendar']),
                    'house' => intval($item['house']),
                    'image' => $item['image'],
                    'new_price' => intval($item['new_price']),
                    'min_people' => intval($item['peopleCount']),
                    'content' => $item['description'],
                    'price_description' => $item['sale_text'],
                    'group' => $item['group'] ?? null,
                ];
            }
            return [
                'id' => $this->id,
                'interval' => $this->getInterval(),
                'calendars' => $calendars,
                'variants' => $this->getVariants(),
                'variant_default'=> $variantByDefault
            ];
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

        public function getInterval(){
            $intervalId = get_post_meta($this->id, 'mastak_event_tab_type_10_interval', 1);
            $result = [
                'id' => $intervalId,
                'from' => get_post_meta($intervalId, "season_from", 1),
                'to' => get_post_meta($intervalId, "season_to", 1)
            ];

            $dateEndDT = new DateTime($result['to']);
            $period = new DatePeriod(
                new DateTime($result['from']),
                new DateInterval('P1D'),
                $dateEndDT->modify( '+1 day' )
            );
    
            $days = [];
            foreach ($period as $key => $value) {
                $days[] = $value->format('Y-m-d');    
            }
            $result['days'] = $days;
            
            return $result;
        }

        public function getVariants(){
            $result = [];
            $variants = get_post_meta($this->id, 'mastak_event_tab_type_10_variants', 1);
            if(!empty($variants)){
                $opts = get_option('mastak_booking_appearance_options');
                foreach((array) $variants as $variant){
                    $result[] = VariantFactory::getVaraintById($variant, $opts);
                }
            }   
            return $result;
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