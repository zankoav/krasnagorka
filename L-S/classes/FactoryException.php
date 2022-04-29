<?php

namespace LsFactory;

use Ls\Wp\Log as Log;

class FactoryException extends \Exception {

    protected $type;

    public function __construct($message, $type, $code = 0) {
		parent::__construct($message, $code);
        $this->type = $type;
	}

    public function __toString() {
        return "[{$this->type}]: {$this->message}";
    }

    public function getResponse(){
        Log::error($this->type, $this->message);
        return ['error' => 
            [   
                'code' => $this->code,
                'type' => $this->type,
                'message' => $this->__toString()
            ]
        ];
    }
}
