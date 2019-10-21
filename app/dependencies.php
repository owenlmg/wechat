<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-09
 * Time: 13:21
 */
use Slim\Http\Request;
use Slim\Http\Response;

$container = $app->getContainer();


$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['database'] . ';charset=' . $db['charset'],
        $db['username'], $db['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};



/*
 * Slim JWT 身份验证中间件
 * https://github.com/tuupola/slim-jwt-auth
 *
 * 参数说明
 *
 * cookie      ：使用 cookie 存储 Token.class，此参数设置 cookie 的名称
 * secure      ：是否使用 HTTPS 验证
 * relaxed     ：不进行 HTTPS 验证的域名
 * secret      ：密钥
 * path        : 需要进行身份验证的路径，设置为 '/' 表示验证全部的路径
 * passthrough ：不需要进行身份验证的路径
 * attribute   ：在 Request 中的标志，可通过 $request->getAttribute('') 读取
 * environment ：
 * header      ：在 header 中的标志，默认是 Authorization，配合 environment 设置一起使用
 * error       : 未能通过验证时的回调函数
 * callback    : 通过身份验证时的回调函数
 */
$app->add(
    new \Tuupola\Middleware\JwtAuthentication(
        [
            "attribute" => "JWT_Auth",
            "path" => "/app",
            "ignore" => ["/app/auth","/open/"],
            "passthrough" => "/token",
            "logger" => $container->logger,
            "environment" => ["HTTP_JWT_AUTH", "REDIRECT_HTTP_JWT_AUTH"],
            "header" => "token",
//            "secret" => getenv("JWT_SECRET"),
            "secret" => "www.easycon.cn",
            "secure" => false,
            "error" => function ($response, $arguments) {
                $data["code"] = "-2";
                $data["message"] = $arguments["message"];
                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            },
            "before" => function (Request $request, $arguments) {
//                $request = $request->withRequestTarget(str_replace("/app", "", $request->getRequestTarget()));
                $_SESSION['user'] = $arguments["decoded"]['user'];
            }
        ]
    )
);

$app->add(function (Request $request, Response $response, $next) {
    $path = $request->getRequestTarget();
//    $token = $this->app->container->jwt;
    if (isset($_SESSION['user']) || strpos($path, '/auth/') || strpos($path, '/auth/') == 0 || strpos($path, '/app/') || strpos($path, '/app/') == 0) {
        return $next($request, $response);
    } else {
        return $response->withJson(['code' => -2]);
    }
});

