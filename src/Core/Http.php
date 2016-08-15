<?php namespace zgldh\Kefu5\Core;

use Exception;
use zgldh\Kefu5\Client;

class Http
{

    public static function send(Client $client, $endPoint, $data = null, $method = 'GET', $contentType = 'application/json')
    {

        $url = $client->getApiUrl() . $endPoint;
        $method = strtoupper($method);
        if (null == $data) {
            $data = new stdClass();
        } else if ($contentType == 'application/json' && $method != 'GET' && $method != 'DELETE') {
            $data = json_encode($data);
        }
        if ($method == 'POST') {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if (is_array($data)) {
                if (isset($data['upload'])) {
                    $filename = $data['upload'];
                    $file = fopen($filename, 'r');
                    $size = filesize($filename);
                    $fileData = fread($file, $size);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $fileData);
                    curl_setopt($curl, CURLOPT_INFILE, $file);
                    curl_setopt($curl, CURLOPT_INFILESIZE, $size);
                }
            }
        } else if ($method == 'PUT') {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } else {
            $url = $url . ($data != null ? (strpos($url, '?') === false ? '?' : '&') .
                    http_build_query($data) : '');
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, ($method ? $method : 'GET'));
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERPWD, $client->getAuthText());
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: ' . $contentType, 'Accept: application/json'));
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        $response = curl_exec($curl);
        if ($response === false) {
            throw new Exception(sprintf('Curl error message: "%s" in %s', curl_error($curl), __METHOD__));
        }
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $responseBody = substr($response, $headerSize);
        $client->setDebug(
            curl_getinfo($curl, CURLINFO_HEADER_OUT),
            curl_getinfo($curl, CURLINFO_HTTP_CODE),
            substr($response, 0, $headerSize),
            $responseBody);
        curl_close($curl);
        return json_decode($responseBody);
    }
}