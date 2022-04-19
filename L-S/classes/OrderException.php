<?php

namespace LsFactory;

use LsFactory\FactoryException;

class OrderException extends FactoryException {

    public function __construct($message, $code = 0) {
		parent::__construct($message, 'OrderException', $code);
	}

}
