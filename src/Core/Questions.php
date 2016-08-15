<?php namespace zgldh\Kefu5\Core;

use zgldh\Kefu5\Client;

class Questions extends ClientAbstract
{

    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * 社区问题列表
     * @throws ResponseException
     * @return mixed
     */
    public function findAll()
    {
        $url = 'questions';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的社区问题
     * @param int $question_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($question_id = '')
    {
        $url = 'questions';
        $this->validatePara('int', $question_id, 'question_id', __METHOD__);
        $url = $url . '/' . $question_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 创建社区问题
     * @param int $topic_id
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function create($topic_id = '', $data = '')
    {
        $url = 'questions';
        $this->validatePara('int', $topic_id, 'topic_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data['topic_id'] = $topic_id;
        $data = array('question' => $data);
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 修改指定的社区问题
     * @param int $question_id
     * @param array $data
     * @throws MissingParametersException
     * @return mixed
     */
    public function update($question_id = '', $data = '')
    {
        $url = 'questions';
        $this->validatePara('int', $question_id, 'question_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('question' => $data);
        $url = $url . '/' . $question_id;
        $response = Http::send($this->client, $url, $data, 'PUT');

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的社区问题
     * @param int $question_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($question_id = '')
    {
        $url = 'questions';
        $this->validatePara('int', $question_id, 'question_id', __METHOD__);
        $url = $url . '/' . $question_id;
        Http::send($this->client, $url, '', 'DELETE');
        return ($this->validateResponse('', __METHOD__, 'delete'));

    }

    /**
     * 查看指定问题的所有回复 || 查看指定问题的指定回复
     * @param int $question_id , int $comment_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function comments($question_id = '', $comment_id = '')
    {
        $url = 'questions';
        $this->validatePara('int', $question_id, 'question_id', __METHOD__);
        if ($comment_id) {
            $this->validatePara('int', $comment_id, 'comment_id', __METHOD__);
        }
        $url = $comment_id ? $url . '/' . $question_id . '/comments/' . $comment_id
            : $url . '/' . $question_id . '/comments';
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 回复指定社区问题
     * @param int $question_id
     * @param array $data
     * @return Ambigous <boolean, string, stdClass>
     */
    public function reply($question_id = '', $data = '')
    {
        $url = 'questions';
        $this->validatePara('int', $question_id, 'question_id', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $data = array('question_comment' => $data);
        $url = $url . '/' . $question_id . '/comments';
        $response = Http::send($this->client, $url, $data, 'POST');

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }
}