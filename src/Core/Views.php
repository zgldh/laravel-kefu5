<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Views extends ClientAbstract
{


    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function __call($name, $arguments)
    {
        $this->validateCall($name, __CLASS__);
    }

    /**
     * 工单查看分类列表
     * @param string $status 'active' or ''
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($status = '')
    {
        $url = 'views';
        $this->validatePara(array('active', ''), $status, 'status', __METHOD__);
        $url = $status ? $url . '/' . $status : $url;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定的查看分类
     * @param int $view_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($view_id = '')
    {
        $url = 'views';
        $this->validatePara('int', $view_id, 'view_id', __METHOD__);
        $url = $url . '/' . $view_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定查看分类里的所有工单
     * @param int $view_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function tickets($view_id = '')
    {
        $url = 'views';
        $this->validatePara('int', $view_id, 'view_id', __METHOD__);
        $url = $url . '/' . $view_id . '/tickets';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));

    }

    /**
     * 获取指定查看分类的工单个数
     * @param int $id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function count($view_id = '')
    {
        $url = 'views';
        $this->validatePara('int', $view_id, 'view_id', __METHOD__);
        $url = $url . '/' . $view_id . '/count';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取多个查看分类的工单个数
     * @param array $ids
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function count_many($ids = '')
    {
        $url = 'views/count_many';
        if ($this->validatePara('array', $ids, 'ids', __METHOD__)) {
            foreach ($ids as $v) {
                $this->validatePara('int', $v, "array ids's value ", __METHOD__);
            }
            $ids = implode(',', $ids);
        }
        $url = $url . '?ids=' . $ids;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }
}