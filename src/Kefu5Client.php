<?php namespace zgldh\Kefu5;

/**
 * Created by PhpStorm.
 * User: zgldh
 * Date: 2016/8/15
 * Time: 16:50
 */
class Kefu5Client
{
    private $config = null;

    public function __construct($config = null)
    {
        if (!$config) {
            $config = config('services.kefu5');
        }
        $this->config = $config;
    }

    /**
     * 以管理员身份使用
     * @param $adminEmail
     * @param $adminPassword
     * @return Client
     */
    public function withAdmin($adminEmail, $adminPassword)
    {
        $client = new Client($this->config['domain'], $adminEmail);
        $client->setAuth('password', $adminPassword);
        return $client;
    }

    /**
     * 以客服身份使用
     * @param $agentEmail
     * @param $agentPassword
     * @return Client
     */
    public function withAgent($agentEmail, $agentPassword)
    {
        $client = new Client($this->config['domain'], $agentEmail);
        $client->setAuth('password', $agentPassword);
        return $client;
    }

    /**
     * 以普通用户身份使用
     * @param $userEmail
     * @return Client
     */
    public function withEndUser($userEmail)
    {
        $client = new Client($this->config['domain'], $userEmail);
        $client->setAuth('token', $this->config['token']);
        return $client;
    }

    /**
     * 得到SSO重定向URL
     * @param string $username 用户名或电子邮箱
     * @param array $extraData
     *                         [
     *                         'time'=> kefu5提供的时间戳，可以留空,
     *                         'return_to'=> kefu5提供的跳转URL，可以留空,
     *                         'name'=> '用户昵称|Email',
     *                         'phone'=> '用户的手机',
     *                         'photo'=> '用户的头像地址，必须以http://或https://开头',
     *                         'rememberMe'=> true 表示保持登录的连接时间至30天,false 表示30分钟后无活动自动登录过期
     *                         ]
     */
    public function sso($username, $extraData = [])
    {
        if (isset($extraData['time'])) {
            $time = $extraData['time'];
            unset($extraData['time']);
        } elseif (class_exists('\App')) {
            $time = \App::make('request')->get('time');
        } else {
            $time = time();
        }
        $urlParameters = ['time' => $time];

        if (isset($extraData['return_to'])) {
            $urlParameters['return_to'] = $extraData['return_to'];
            unset($extraData['return_to']);
        } else {
            $returnTo = null;
        }

        /* 您的安全校验码(API通信密匙) */
        $key = $this->config['token'];
        /* 您的云客服平台地址 */
        $url = 'http://' . $this->config['domain'] . '/user/remote';
        /* 建立通信串 */
        $token = md5($username . $time . $key);

        $urlParameters['username'] = $username;
        $urlParameters['token'] = $token;

        /* 指定用户名或者手机(可选) */
        if (isset($extraData['name'])) {
            $urlParameters['name'] = $extraData['name'];
        }
        if (isset($extraData['phone'])) {
            $urlParameters['phone'] = $extraData['phone'];
        }
        if (isset($extraData['photo'])) {
            $urlParameters['photo'] = $extraData['photo'];
        }
        if (isset($extraData['rememberMe'])) {
            $urlParameters['rememberMe'] = $urlParameters['rememberMe'] ? 1 : 0;
        }

        $url .= http_build_query($urlParameters);

        return $url;
    }

}