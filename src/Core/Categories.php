<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Categories extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 文档分区列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'categories';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的文档分区信息
     * @param int $category_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($category_id = '')
    {
        $url = 'categories';
        $this->validatePara('int', $category_id, 'category_id', __METHOD__);
        $url = $url . '/' . $category_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的文档分区下的所有分类信息(如果调用权限为普通用户，则查看权限为客服的分类信息无法查看)
     * @param int $category_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function forums($category_id = '')
    {
        $url = 'categories';
        $this->validatePara('int', $category_id, 'category_id', __METHOD__);
        $url = $url . '/' . $category_id . '/forums';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建文档分区
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $url = 'categories';
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('category' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定的文档分区
     * @param int $category_id
     * @param array $data
     * @throws MissingParametersException
     * @return mixed
     */
    public function update($category_id = '', $data = '')
    {
        $url = 'categories';
        $this->validatePara('int', $category_id, 'category_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('category' => $data);
        $url = $url . '/' . $category_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的文档分区
     * @param int $category_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($category_id = '')
    {
        $url = 'categories';
        $this->validatePara('int', $category_id, 'category_id', __METHOD__);
        $url = $url . '/' . $category_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));

    }
}