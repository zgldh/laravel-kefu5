<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Forums extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 文档分类列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'forums';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的文档分类信息
     * @param int $forum_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($forum_id = '')
    {
        $url = 'forums';
        $this->validatePara('int', $forum_id, 'forum_id', __METHOD__);
        $url = $url . '/' . $forum_id;
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的文档分类下的所有正式文档
     * @param int $forum_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function posts($forum_id = '', $status = '')
    {
        $url = 'forums';
        $this->validatePara('int', $forum_id, 'forum_id', __METHOD__);

        $url = $url . '/' . $forum_id . '/posts';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建文档分类
     * @param int $category_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($category_id = '', $data = '')
    {
        $url = 'forums';
        $this->validatePara('int', $category_id, 'category_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data['category_id'] = $category_id;
        $data = array('forum' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定的文档分类
     * @param int $forum_id
     * @param array $data
     * @throws MissingParametersException
     * @return mixed
     */
    public function update($forum_id = '', $data = '')
    {
        $url = 'forums';
        $this->validatePara('int', $forum_id, 'forum_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('forum' => $data);
        $url = $url . '/' . $forum_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的文档分类
     * @param int $forum_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($forum_id = '')
    {
        $url = 'forums';
        $this->validatePara('int', $forum_id, 'forum_id', __METHOD__);
        $url = $url . '/' . $forum_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));

    }
}