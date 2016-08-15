<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Groups extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 客服组列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'groups';
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定客服组
     * @param int $group_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($group_id = '')
    {
        $url = 'groups';
        $this->validatePara('int', $group_id, 'group_id', __METHOD__);
        $url = $url . '/' . $group_id;
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建客服组
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('group' => $data);
        $url = 'groups';
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定客服组
     * @param int $group_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function update($group_id = '', $data = '')
    {
        $url = 'groups';
        $this->validatePara('int', $group_id, 'group_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('group' => $data);
        $url = $url . '/' . $group_id;
        $response = Http::send($this->client, $url, $data, 'PUT');
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定客服组
     * @param int $group_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function delete($group_id = '')
    {
        $url = 'groups';
        $this->validatePara('int', $group_id, 'group_id', __METHOD__);
        $url = $url . '/' . $group_id;
        Http::send($this->client, $url, '', 'DELETE');
        return ($this->validateResponse('', __METHOD__, 'delete'));
    }
}