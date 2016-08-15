# laravel-kefu5
客服5的RESTFul API。
Laravel 5 框架专用。

## 依赖 Requirement

1. Laravel 5.1/5.2

## 安装 Install

1. composer require zgldh/laravel-kefu5
2. ```config/services.php```  
    
    新增配置

    ```php
        'kefu5' => [
            'domain' => // 您的云客服平台kf5二级域名地址前缀。如 abc.kf5.com 。不要带 http://， 不要带最后的斜杠
            'token' => // 您的云客服平台的API密钥。 如 '60a0319****7fcdf63461c5ad18106'
        ],
    ```
3. Done

## 用法 Usage

1. 管理员查询工单列表
    
    ```php
       use zgldh\Kefu5\Kefu5Client;   
  
       $client = new Kefu5Client()->withAdmin($adminEmail, $adminPassword);
       $list = $client->tickets()->findAll();
    ```
 

2. 客服查询工单列表

    ```php
       use zgldh\Kefu5\Kefu5Client;   
  
       $client = new Kefu5Client()->withAgent($agentEmail, $agentPassword);
       $list = $client->tickets()->findAll();
    ```

3. 普通用户查询工单列表

    ```php
       use zgldh\Kefu5\Kefu5Client;   
  
       $client = new Kefu5Client()->withEndUser($userEmail);
       $list = $client->requests()->findAll();
    ```
 
4. 更多API用法请访问： https://github.com/waterank/KF5SDK-PHP/blob/master/index.php
    
5. 得到SSO重定向URL

    ```php
       use zgldh\Kefu5\Kefu5Client;   
  
       $username = \Auth::user()->name;
       $redirectURL = new Kefu5Client()->sso($username,
           [
               'name'=> '用户昵称|Email',
               'phone'=> '用户的手机',
               'photo'=> '用户的头像地址，必须以http://或https://开头',
               'rememberMe'=> true 表示保持登录的连接时间至30天,false 表示30分钟后无活动自动登录过期
           ]
       );
       
       return redirect($redirectURL);
    ```

    
待续

    
