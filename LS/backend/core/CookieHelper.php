<?php
	class CookieHelper {

		public function getCookieValue($key) {
			return isset( $_COOKIE[ $key ] ) ? $_COOKIE[ $key ] : false;
		}
	}