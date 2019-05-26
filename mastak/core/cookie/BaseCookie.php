<?php


	class BaseCookie {

		public function getCookieValue($key) {
			return isset( $_COOKIE[ $key ] ) ? $_COOKIE[ $key ] : false;
		}
	}