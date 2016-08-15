<?php namespace zgldh\Kefu5\Core;

use Exception;

class MissingParametersException extends Exception
{

    /**
     * @param string $method
     * @param array $params
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $method)
    {
        parent::__construct($method . ' ' . $message);
    }

}