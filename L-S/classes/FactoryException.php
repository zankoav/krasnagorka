<?php

namespace LsFactory;

use Ls\Wp\Log as Log;

class FactoryException extends \Exception {

    protected $type;
    protected $context;

    public function __construct($message, $type, $code = 0, array $context = []) {
		parent::__construct($message, $code);
        $this->type = $type;
		$this->context = $context;
	}

    public function __toString() {
        return "[{$this->type}]: {$this->message}";
    }

    public function getResponse(){
        Log::error($this->type, array_merge([
            'message' => $this->message,
            'code' => $this->code
        ], $this->context));
        return ['error' => 
            [   
                'code' => $this->code,
                'type' => $this->type,
                'message' => $this->__toString()
            ]
        ];
    }
}
