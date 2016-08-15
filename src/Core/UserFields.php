<?php namespace zgldh\Kefu5\Core;

class UserFields extends ClientAbstract
{

    /**
     * 用户自定义字段列表
     * @param string $status 'active'
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($status = '')
    {
        $url = 'user_fields';
        $this->validatePara(array('active', ''), $status, 'status', __METHOD__);
        $url = $status ? $url . '/' . $status : $url;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的自定义字段
     * @param int $user_field_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($user_field_id = '')
    {
        $url = 'user_fields';
        $this->validatePara('int', $user_field_id, 'user_field_id', __METHOD__);
        $url = $url . '/' . $user_field_id;
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的自定义字段
     * @param string $user_field_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($user_field_id = '')
    {
        $url = 'user_fields';
        $this->validatePara('int', $user_field_id, 'user_field_id', __METHOD__);
        $url = $url . '/' . $user_field_id;
        Http::send($this->client, $url, '', 'DELETE');
        return ($this->validateResponse('', __METHOD__, 'delete'));
    }
}