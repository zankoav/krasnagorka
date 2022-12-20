<?php
    namespace Mastak;

	class BaseMeta {
		public function __construct( $post_id ) {
			foreach ( (array) get_post_meta( $post_id ) as $k => $v ) {
				$this->$k = $v[0];
			}
		}
	}