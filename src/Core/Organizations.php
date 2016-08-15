<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Organizations extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 公司组织列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'organizations';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定公司组织
     * @param int $organization_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($organization_id = '')
    {
        $url = 'organizations';
        $this->validatePara('int', $organization_id, 'organization_id', __METHOD__);
        $url = $url . '/' . $organization_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定公司组织下的所有用户
     * @param int $organization_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function users($organization_id = '')
    {
        $url = 'organizations';
        $this->validatePara('int', $organization_id, 'organization_id', __METHOD__);
        $url = $url . '/' . $organization_id . '/users';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建公司组织
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('organization' => $data);
        $url = 'organizations';
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定公司组织
     * @param int $organization_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function update($organization_id = '', $data = '')
    {
        $url = 'organizations';
        $this->validatePara('int', $organization_id, 'organization_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('organization' => $data);
        $url = $url . '/' . $organization_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定公司组织
     * @param int $organization_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function delete($organization_id = '')
    {
        $url = 'organizations';
        $this->validatePara('int', $organization_id, 'organization_id', __METHOD__);
        $url = $url . '/' . $organization_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));
    }

    /**
     * 获取指定公司组织的工单请求
     * @param int $organization_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function requests($organization_id = '')
    {
        $url = 'organizations';
        $this->validatePara('int', $organization_id, 'organization_id', __METHOD__);
        $url = $url . '/' . $organization_id . '/requests';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }
}