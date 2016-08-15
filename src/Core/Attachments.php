<?php namespace zgldh\Kefu5\Core;

class Attachments extends ClientAbstract
{
    /**
     * 上传附件
     * @param string $filename
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function upload($filename = '', $data = '')
    {
        $url = 'attachments';
        $this->validatePara('empty', $filename, 'filename', __METHOD__);
        $this->validatePara('array', $data, 'data', __METHOD__);
        $url = $url . '?filename=' . $filename;
        $response = Http::send($this->client, $url, $data, 'POST', 'application/binary');

        return ($this->validateResponse($response, __METHOD__, 'create'));

    }

    /**
     * 查看指定附件
     * @param int $id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function find($id = '')
    {
        $url = 'attachments';

        $this->validatePara('int', $id, 'id', __METHOD__);
        $url = $url . '/' . $id;
        $response = Http::send($this->client, $url);

        return ($this->validateResponse($response, __METHOD__, 'create'));
    }

    /**
     * 删除指定附件
     * @param int $id
     * @throws MissingParametersException
     * @throws ResponseException
     * @return string
     */
    public function delete($id = '')
    {
        $url = 'attachments';
        $this->validatePara('int', $id, 'id', __METHOD__);
        $url = $url . '/' . $id;
        Http::send($this->client, $url, '', 'DELETE');

        return ($this->validateResponse('', __METHOD__, 'delete'));

    }
}