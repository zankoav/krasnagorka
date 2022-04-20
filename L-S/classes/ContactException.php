<?php

namespace LsFactory;

use LsFactory\FactoryException;

class ContactException extends FactoryException {

    public function __construct($message, $code = 0) {
		parent::__construct($message, 'ContactException', $code);
	}

}
