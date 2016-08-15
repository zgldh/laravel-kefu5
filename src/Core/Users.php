<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Users extends ClientAbstract
{

    /**
     *
     * @var 用户自定义字段
     */
    protected $fields;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->fields = new UserFields($client);
    }

    public function __call($name, $arguments)
    {
        $this->validateCall($name, __CLASS__);
    }

    /**
     * 获取用户列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($role = '')
    {
        $url = 'users';
        $this->validatePara(array('admin', 'agent', 'end_user'), $role, 'role', __METHOD__);
        $url = $role ? $url . '?role=' . $role : $url;
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定用户信息
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看自己的信息
     * @throws ResponseException
     * @return mixed
     */
    public function mine()
    {
        $url = 'users/me';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取多个用户信息
     * @param array $ids
     * @throws MissingParametersException
     */
    public function show_many($ids = '')
    {
        $url = 'users/show_many';
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
     * 创建用户信息
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($data = '')
    {
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('user' => $data);
        $url = 'users';
        $response = Http::send($this->client, $url, $data, 'POST');
        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定用户信息
     * @param int $user_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function update($user_id = '', $data = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('user' => $data);
        $url = $url . '/' . $user_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定用户
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));
    }

    /**
     * 搜索用户
     * @param string $query
     * @throws ResponseException
     * @return mixed
     */
    public function search($query = '')
    {
        $url = 'users/search';
        $data = '';
        if (!empty($query)) {
            $data['query'] = $query;
        }
        $response = Http::send($this->client, $url, $data);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定用户的工单请求
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function requests($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id . '/requests';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定用户的所属的所有客服组
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function groups($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id . '/groups';
        $response = Http::send($this->client, $url);
        return $response;
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定用户创建的文档
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function posts($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id . '/posts';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 获取指定用户创建的社区问题
     * @param int $user_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function questions($user_id = '')
    {
        $url = 'users';
        $this->validatePara('int', $user_id, 'user_id', __METHOD__);
        $url = $url . '/' . $user_id . '/questions';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }
}