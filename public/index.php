<?php
header('Access-Control-Allow-Origin: *');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require '../app/utils/Utils.php';

$settings = require '../app/setting.php'; //引入设置的配置文件

$app = new Slim\App($settings);

require '../app/dependencies.php'; //引入controller配置文件
require '../app/routes.php'; //引入路由管理文件
session_start();
$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to !");
    return $response;
});
//$app->get('/hello[/{name}]', function ($request, $response, $args) {
//    $response->write("Hello, " . $args['name']);
//    return $response;
//})->setArgument('name', 'World!');

$app->run();