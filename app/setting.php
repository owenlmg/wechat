<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-09
 * Time: 13:22
 */
return [
    'settings' => [
        'addContentLengthHeader' => false,
        'displayErrorDetails' => true, //开启错误提示
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            // Illuminate/database configuration
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'wechat',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],
        'wechat' => [
            'appid' => 'wxbbcaf1d5b914747b',
            'appsecret' => '5aabe87f9eba6ed92e3cf6f2b9c02ac6',
            'cache_dir' => 'C:\soft\git\wechat\app\Wechat\cache',
            'callback_base_page' => 'http://wechat.rsses.xyz/page/callback_snsapi_base.php',
            'callback_userinfo_page' => 'http://wechat.rsses.xyz/page/callback_snsapi_userinfo.php'
        ]
    ],
];