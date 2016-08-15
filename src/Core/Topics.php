<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Topics extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 社区话题列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'topics';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的社区话题
     * @param int $topic_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($topic_id = '')
    {
        $url = 'topics';
        $this->validatePara('int', $topic_id, 'topic_id', __METHOD__);
        $url = $url . '/' . $topic_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的社区话题下的所有问题
     * @param string $topic_id
     * @return Ambigous <boolean, string, stdClass>
     */
    public function questions($topic_id = '')
    {
        $url = 'topics';
        $this->validatePara('int', $topic_id, 'topic_id', __METHOD__);
        $url = $url . '/' . $topic_id . '/questions';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建社区话题
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $url = 'topics';
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('topic' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');
        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定的社区话题
     * @param int $topic_id
     * @param array $data
     * @throws MissingParametersException
     * @return mixed
     */
    public function update($topic_id = '', $data = '')
    {
        $url = 'topics';
        $this->validatePara('int', $topic_id, 'topic_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('topic' => $data);
        $url = $url . '/' . $topic_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的社区话题
     * @param int $topic_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($topic_id = '')
    {
        $url = 'topics';
        $this->validatePara('int', $topic_id, 'topic_id', __METHOD__);
        $url = $url . '/' . $topic_id;
        Http::send($this->client, $url, '', 'DELETE');
        return ($this->validateResponse('', __METHOD__, 'delete'));

    }
}