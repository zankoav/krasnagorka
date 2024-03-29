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
            $interval = $this->getInterval();
            $calendars = [];
            $terem_options = get_option('mastak_terem_appearance_options');
            $kalendars = $terem_options['kalendar'];
            foreach($items as $item){
                $calendarId = intval($item['calendar']);
                $isTeremRoom = get_term_meta($calendarId, 'kg_calendars_terem', 1);

                if(empty($item['image'])){
                    $item['image'] = get_the_post_thumbnail_url($item['house'], 'full');
                }
                
                $dateStart = $interval['from'];
                $dateEnd = $interval['to'];
                if(Booking_Form_Controller::isAvailableOrder($calendarId, $dateStart, $dateEnd, false)){
                    $calendars[] = [
                        'calendar' => $calendarId,
                        'calendar_name' => $item['calendarName'],
                        'max_people' => intval($item['maxPeople']),
                        'house' => intval($item['house']),
                        'image' => $item['image'],
                        'old_price' => intval($item['old_price']),
                        'new_price' => intval($item['new_price']),
                        'old_price_child' => intval($item['old_price_child']),
                        'new_price_child' => intval($item['new_price_child']),
                        'enabled_child' => $item['enabled_child'] === 'on',
                        'min_people' => intval($item['peopleCount']),
                        'content' => $item['description'],
                        'price_description' => $item['sale_text'],
                        'group' => $item['group'] ?? null,
                    ];
                }
            }
            return [
                'id' => $this->id,
                'interval' => $interval,
                'calendars' => $calendars,
                'variants' => $this->getVariants(),
                'variant_default'=> $variantByDefault
            ];
        }

        public function getSelectedCalendar($calendarId, $variantId){
            $variant = VariantFactory::getVaraintById($variantId);
            $result = [
                'variant' => $variant
            ];
            $interval = $this->getInterval();
            $result['interval'] = $interval; 
            $items = $this->getItems();
            foreach($items as $item){
                if($calendarId == intval($item['calendar'])){
                    $dateStart = $interval['from'];
                    $dateEnd = $interval['to'];

                    $oldPrice = str_replace(",",".", $item['old_price'] ?? "0");
                    $oldPrice = floatval($oldPrice);

                    $newPrice = str_replace(",",".", $item['new_price'] ?? "0");
                    $newPrice = floatval($newPrice);

                    $oldPriceChild = str_replace(",",".", $item['old_price_child'] ?? "0");
                    $oldPriceChild = floatval($oldPriceChild);

                    $newPriceChild = str_replace(",",".", $item['new_price_child'] ?? "0");
                    $newPriceChild = floatval($newPriceChild);

                    $result['calendar'] = [
                        'calendar' => $calendarId,
                        'calendar_name' => $item['calendarName'],
                        'max_people' => intval($item['maxPeople']),
                        'house' => intval($item['house']),
                        'image' => $item['image'],
                        'old_price' => $oldPrice,
                        'new_price' => $newPrice,
                        'old_price_child' => $oldPriceChild,
                        'new_price_child' => $newPriceChild,
                        'enabled_child' => $item['enabled_child'] === 'on',
                        'min_people' => intval($item['peopleCount']),
                        'content' => $item['description'],
                        'price_description' => $item['sale_text'],
                        'group' => $item['group'] ?? null,
                    ];
                    break;
                }
            }
            return $result;
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

            $dFrom = new DateTime($result['from']);
            $dFrom = $dFrom->modify('-1 day');
            $result['from'] = $dFrom;

            $dateEndDT = new DateTime($result['to']);
            $period = new DatePeriod(
                $dFrom,
                new DateInterval('P1D'),
                $dateEndDT->modify( '+1 day' )
            );
    
            $days = [];
            foreach ($period as $key => $value) {
                $days[] = $value->format('d.m.Y');    
            }
            $result['days'] = $days;

            return $result;
        }

        public function getVariants(){
            $result = [];
            $variants = get_post_meta($this->id, 'mastak_event_tab_type_10_variants', 1);
            if(!empty($variants)){
                foreach((array) $variants as $variant){
                    $result[] = VariantFactory::getVaraintById($variant);
                }
            }   
            return $result;
        }

        private function initHouses($items){
            foreach($items as &$item){
                $item['house'] = $this->getHouseIdByCalendarId($item['calendar']);
                $item['maxPeople'] = get_term_meta($item['calendar'], 'kg_calendars_persons_count', 1);
                $term = get_term_by( 'id', $item['calendar'], 'sbc_calendars');
                $item['calendarName'] = $term->name;
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