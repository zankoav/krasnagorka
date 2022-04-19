<?php

namespace LsFactory;

use LsFactory\FactoryException;

class OrderException extends FactoryException {

    public function __construct($message, $type = 'Order Exception',  $code = 0) {
		parent::__construct($message, $type, $code);
	}

}
