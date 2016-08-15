<?php namespace zgldh\Kefu5;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     */
    public function withAdmin($adminEmail, $adminPassword)
    {
        $client = new \Client()
    }

    /**
     * 以客服身份使用
     * @param $agentEmail
     * @param $agentPassword
     */
    public function withAgent($agentEmail, $agentPassword)
    {

    }

    /**
     * 以普通用户身份使用
     * @param $userEmail
     */
    public function withEndUser($userEmail)
    {

    }

    /**
     * 得到SSO重定向URL
     * @param $username 用户名或电子邮箱
     * @param array $extraData
     *                  [
     *                  'name'=> '用户昵称|Email',
     *                  'phone'=> '用户的手机',
     *                  'photo'=> '用户的头像地址，必须以http://或https://开头',
     *                  'rememberMe'=> true 表示保持登录的连接时间至30天,false 表示30分钟后无活动自动登录过期
     *                  ]
     */
    public function sso($username, $extraData = [])
    {

    }

}