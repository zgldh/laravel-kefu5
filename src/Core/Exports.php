<?php namespace zgldh\Kefu5\Core;

class Exports extends ClientAbstract
{

    /**
     * 导出工单
     * @param array $data
     * @throws MissingParametersException
     * @throws ResponseException
     * @return mixed
     */
    public function tickets($data = '')
    {
        $url = 'exports/tickets';
        if ($data) {
            $this->validatePara('array', $data, 'data', __METHOD__);
            $url = $url . '?' . http_build_query($data);
        }
        $response = Http::send($this->client, $url);
        return ($this->validateResponse($response, __METHOD__));
    }
}