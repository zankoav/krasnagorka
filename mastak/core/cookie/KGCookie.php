<?php
	/**
	 * Created by PhpStorm.
	 * User: alexandrzanko
	 * Date: 4/6/18
	 * Time: 12:15 PM
	 */

	class KGCookie extends BaseCookie {

		const RUS = 'rus';
		const EUR = 'eur';
		const USD = 'usd';
		const BYN = 'byn';
		const CURRENCY = 'currency';
		const CURRENCY_SELECTED = 'cur_selected';


		public function getCurrnecy() {
			$currency          = $this->getCookieValue( self::CURRENCY );
			$currency_selected = $this->getCookieValue( self::CURRENCY_SELECTED );


			if ( ! empty ( $currency ) and ! empty( $currency_selected ) ) {
				return [
					"currency"          => $currency,
					"currency_selected" => $currency_selected
				];
			} else {
				return [
					"currency"          => 1,
					"currency_selected" => self::BYN
				];
			}
		}

	}

