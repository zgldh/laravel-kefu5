<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Tickets extends ClientAbstract
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
     * 工单列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($page = '', $per_page = '')
    {
        $url = 'tickets';
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
     * 查看单个工单
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($ticket_id = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看多个工单
     * @param array $ids
     */
    public function show_many($ids = '')
    {
        $url = 'tickets/show_many';
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

    /**
     * 创建工单
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $url = 'tickets';
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('ticket' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');
        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 更新单个指定工单
     * @param int $ticket_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function update($ticket_id = '', $data = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('ticket' => $data);
        $url = $url . '/' . $ticket_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 更新多个指定工单
     * @param int $ids
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function update_many($ids = '', $data = '')
    {
        $url = 'tickets/update_many';
        if ($this->validatePara('array', $ids, 'ids', __METHOD__)) {
            foreach ($ids as $v) {
                $this->validatePara('int', $v, "array ids's value ", __METHOD__);
            }
            $ids = implode(',', $ids);
        }
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('ticket' => $data);
        $url = $url . '?ids=' . $ids;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除单个工单
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function delete($ticket_id = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));
    }

    /**
     * 删除多个工单
     * @param array $ids
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete_many($ids = '')
    {
        $url = 'tickets/delete_many';
        if ($this->validatePara('array', $ids, 'ids', __METHOD__)) {
            foreach ($ids as $v) {
                $this->validatePara('int', $v, "array ids's value ", __METHOD__);
            }
            $ids = implode(',', $ids);
        }
        $url = $url . '?ids=' . $ids;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));
    }

    /**
     * 查看指定工单可用的副本用户
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function collaborators($ticket_id = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id . '/collaborators';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定工单被关联的事务列表
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function incidents($ticket_id = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id . '/incidents';
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看故障类型的工单列表
     * @throws ResponseException
     * @return mixed
     */
    public function problems()
    {
        $url = 'tickets/problems';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定工单下的所有回复
     * @param int $ticket_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function comments($ticket_id = '')
    {
        $url = 'tickets';
        $this->validatePara('int', $ticket_id, 'ticket_id', __METHOD__);
        $url = $url . '/' . $ticket_id . '/comments';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }
}