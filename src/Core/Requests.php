<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Requests extends ClientAbstract
{

    /**
     *
     * @var 工单（普通用户）回复类
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function __call($name, $arguments)
    {
        $this->validateCall($name, __CLASS__);
    }

    public function validate()
    {
        if (!$this->client->validateToken()) {
            throw new CustomException("this is Requests API,please set token");
        }
    }

    /**
     * 工单请求列表
     * @string $status 状态："open", "solved"
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($status = '')
    {
        $this->validate();
        $url = 'requests';
        if ($status)
            $this->validatePara(array('open', 'solved'), $status, 'status', __METHOD__);
        $url = $status ? $url . '/' . $status : $url;
        $url .= '?per_page=4';
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 搜索工单请求
     * @param string $query  关键字
     * @param string $status 状态： "open","solved"
     * @throws ResponseException
     * @return mixed
     */
    public function search($query = '', $status = '')
    {
        $this->validate();
        $url = 'requests/search';
        $data = '';
        if (!empty($query)) $data['query'] = $query;

        if (!empty($status)) $data['status'] = $status;

        $response = Http::send($this->client, $url, $data);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定工单请求
     * @param int $request_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($request_id = '')
    {
        $this->validate();
        $url = 'requests';
        $this->validatePara('int', $request_id, 'request_id', __METHOD__);
        $url = $url . '/' . $request_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建工单请求
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $this->validate();
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('request' => $data);
        $url = 'requests';
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 回复单个工单
     * @param int $request_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function reply($request_id = '', $data = '')
    {
        $this->validate();
        $url = 'requests';
        $this->validatePara('int', $request_id, 'request_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('request' => $data);
        $url = $url . '/' . $request_id;
        $response = Http::send($this->client, $url, $data, 'PUT');
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定工单的所有回复 || 查看指定工单的指定回复
     * @param int $request_id , int $comment_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function comments($request_id = '', $comment_id = '')
    {
        $this->validate();
        $url = 'requests';
        $this->validatePara('int', $request_id, 'request_id', __METHOD__);
        if ($comment_id) {
            $this->validatePara('int', $comment_id, 'comment_id', __METHOD__);
        }
        $url = $comment_id ? $url . '/' . $request_id . '/comments/' . $comment_id
            : $url . '/' . $request_id . '/comments';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

}