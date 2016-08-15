<?php namespace zgldh\Kefu5\Core;

class Fields extends ClientAbstract
{

    /**
     * 工单自定义字段列表
     * @param string $status 'active'
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function findAll($status = '')
    {
        $url = 'ticket_fields';
        $this->validatePara(array('active', ''), $status, 'status', __METHOD__);
        $url = $status ? $url . '/' . $status : $url;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 查看指定的自定义字段
     * @param int $field_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($field_id = '')
    {
        $url = 'ticket_fields';
        $this->validatePara('int', $field_id, 'field_id', __METHOD__);
        $url = $url . '/' . $field_id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__));
    }

    /**
     * 删除指定的自定义字段
     * @param string $field_id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($field_id = '')
    {
        $url = 'ticket_fields';
        $this->validatePara('int', $field_id, 'field_id', __METHOD__);
        $url = $url . '/' . $field_id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));
    }


}