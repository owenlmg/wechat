<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;

use Firebase\JWT\JWT;
use \interop\Container\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;
use utils\SQL;

class AuthController
{
    protected $app;
    protected $pdo;


    public function __construct(ContainerInterface $ci)
    {
        $this->app = $ci;
        $this->pdo = $ci->db;
    }

    /**
     * 登录
     *
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function login(Request $request, Response $response)
    {
        //
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        $sth = $this->pdo->prepare("select id,name_ as name, password,enable from t_user where name_=:username");
        $sth->execute([':username' => $username]);
        $user = $sth->fetchObject('\Model\User');
        if (!isset($user) || !isset($user->id)) {
            return $response->withStatus(StatusCode::HTTP_OK)->withJson(['code' => -1, 'msg' => '用户不存在']);
        }
        if ($password != $user->password) {
            return $response->withStatus(StatusCode::HTTP_OK)->withJson(['code' => -1, 'msg' => '密码不正确']);
        }
        if ($user->enable == '0') {
            return $response->withStatus(StatusCode::HTTP_OK)->withJson(['code' => -1, 'msg' => '账号未启用']);
        }
        unset($user->password);
        unset($user->enable);



        $data = array(
            "iss" => "lmg", //签发者
            "sub" => "Auth",       // 主题
            "aud" => '1',          // 受众
            "iat" => time(),       // 签发时间
            "nbf" => time(),       // 启用时间
            "exp" => time() + 3600 * 24 * 30, // 过期时间
            "user" => $user
        );

        $token = JWT::encode($data, 'lmg_wechat');
        $user->token = $token;

        $_SESSION['userinfo'] = $user;

        return $response->withStatus(StatusCode::HTTP_OK)->withJson(['code' => 1, 'msg' => $user]);
    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();
        return $response->withJson(['code' => 1]);
    }

    public function  version(Request $request, Response $response) {
        return $response->withJson(['currentVersion'=>1]);
    }

}