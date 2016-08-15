<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Triggers extends ClientAbstract
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
     * 触发器列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($page = '', $per_page = '')
    {
        $url = 'triggers';
        $page_para = array();
        if ($page)
            $page_para['page'] = $page;
        if ($per_page)
            $page_para['per_page'] = $per_page;
        if ($page_para)
            $url .= '?' . http_build_query($page_para);
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看单个触发器
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($ticket_id = '')
    {
        $url = 'triggers';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看启动的触发器列表
     * @throws ResponseException
     * @return mixed
     */
    public function active()
    {
        $url = 'triggers/active';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

}