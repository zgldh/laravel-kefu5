<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Posts extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 正式文档列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($status = '')
    {
        $url = 'posts';
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 草稿列表
     * @throws ResponseException
     * @return mixed
     */
    public function draft($status = '')
    {
        $url = 'posts/draft';
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的文档信息
     * @param int $post_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($post_id = '')
    {
        $url = 'posts';
        $this->validatePara('int', $post_id, 'post_id', __METHOD__);
        $url = $url . '/' . $post_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建文档
     * @param int $forum_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($forum_id = '', $data = '')
    {
        $url = 'posts';
        $this->validatePara('int', $forum_id, 'forum_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data['forum_id'] = $forum_id;
        $data = array('post' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定的文档
     * @param int $post_id
     * @param array $data
     * @throws MissingParametersException
     * @return mixed
     */
    public function update($post_id = '', $data = '')
    {
        $url = 'posts';
        $this->validatePara('int', $post_id, 'post_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('post' => $data);
        $url = $url . '/' . $post_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的文档
     * @param int $post_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($post_id = '')
    {
        $url = 'posts';
        $this->validatePara('int', $post_id, 'post_id', __METHOD__);
        $url = $url . '/' . $post_id;
        Http::send($this->client, $url, '', 'DELETE');
        return ($this->validateResponse('', __METHOD__, 'delete'));

    }

    /**
     * 查看多个文档信息
     * @param array $ids
     * @throws MissingParametersException
     */
    public function show_many($ids = '')
    {
        $url = 'posts/show_many';
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
     * 查看指定文档的所有回复 || 查看指定文档的指定回复
     * @param int $post_id , int $comment_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function comments($post_id = '', $comment_id = '')
    {
        $url = 'posts';
        $this->validatePara('int', $post_id, 'post_id', __METHOD__);
        if ($comment_id) {
            $this->validatePara('int', $comment_id, 'comment_id', __METHOD__);
        }
        $url = $comment_id ? $url . '/' . $post_id . '/comments/' . $comment_id
            : $url . '/' . $post_id . '/comments';

        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 回复指定文档
     * @param int $post_id
     * @param array $data
     * @return Ambigous <boolean, string, stdClass>
     */
    public function reply($post_id = '', $data = '')
    {
        $url = 'posts';
        $this->validatePara('int', $post_id, 'post_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('post_comment' => $data);
        $url = $url . '/' . $post_id . '/comments';
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 搜索文档
     * @param string $query
     * @return Ambigous <boolean, string, stdClass>
     */
    public function search($query = '')
    {
        $query = urlencode($query);
        $url = 'posts/search';
        if ($query) {
            $url = $url . '?query=' . (string)$query;
        }
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }
}