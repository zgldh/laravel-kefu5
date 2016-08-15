<?php namespace zgldh\Kefu5\Core;


use Exception;

class ResponseException extends Exception
{

    /**
     * @param string $method
     * @param string $detail
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($object = '', $method)
    {
        print_r($object->client->getDebug());
        echo '<br />';
        parent::__construct('Response to ' . $method . ' is not valid,or the parameter is not correct');

    }

}