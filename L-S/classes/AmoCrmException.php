<?php

namespace LsFactory;

use LsFactory\FactoryException;

class AmoCrmException extends FactoryException {

    public function __construct($message, $code = 300) {
		parent::__construct($message, 'AmoCrmException', $code);
	}

}
