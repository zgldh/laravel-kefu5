<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

abstract class ClientAbstract
{

    /**
     * @var Client
     */
    public $client;
    /**
     * @var int
     */
    protected $lastId;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 根据传入的方式验证参数
     * @param string $type 'array' 'int' 'empty'
     * @param         $para
     * @param string $para_name
     * @param         $method
     * @throws MissingParametersException
     * @return boolean
     */
    public function validatePara($type, $para, $para_name, $method)
    {
        $index = array('array' => 'is_array',
                       'int'   => 'is_numeric');
        if (is_array(($type))) {
            if (!in_array($para, $type)) {
                $warm_type = ' must be ';
                throw new MissingParametersException(' parameter ' . $para_name . $warm_type . implode(',', $type), $method);
            }
        } else {
            if (empty($para) || (isset($index[$type]) ? !$index[$type]($para) : false)) {
                $warm_type = $type == 'empty' ? ' can not be ' : ' must be ';
                throw new MissingParametersException(' parameter ' . $para_name . $warm_type . $type, $method);
            }
        }

        return true;
    }

    /**
     * 验证返回的数据是否为对象，根据传入的方式判断返回的状态码
     * @param  $response
     * @param  $method
     * @param string $type 'create'
     * @throws ResponseException
     * @return boolean
     */
    public function validateResponse($response, $method, $type = '')
    {
        $state_code = $type == 'create' ? '201' : '200';
        if ($type == 'delete') {
            $response = new stdClass();
        }
        if (!is_object($response) || ($this->client->getDebug()->lastResponseCode != $state_code)) {
            throw new ResponseException($this, $method);
        }
        return ($type == 'delete' ? 'success' : $response);
    }

    /**
     * 验证变量类是否存在
     * @param  $name
     * @param  $class
     * @throws CustomException
     * @return boolean
     */
    public function validateCall($name, $class)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            throw new CustomException("No method called $name available in " . __CLASS__);
        }
        return true;
    }


}