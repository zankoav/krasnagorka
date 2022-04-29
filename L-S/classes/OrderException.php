<?php

namespace LsFactory;

use LsFactory\FactoryException;

class OrderException extends FactoryException {

    public function __construct($message, $code = 200) {
		parent::__construct($message, 'OrderException', $code);
	}

}
