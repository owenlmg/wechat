<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class BrowseController extends BaseController
{
    public $table = 't_browse';
    public $searchColumns = ['user_', 'corp'];
    public $tableKeys = ['user_', 'corp', 'time_', 'favorite', 'browse'];
    public $tableKeysCanUpdate = ['user_', 'corp', 'time_', 'favorite', 'browse'];
    public $uniqueKeys = [];

    public function browse(Request $request, Response $response) {
        $id = $request->getParam('id');

        if($id && !is_null($_SESSION['user']->id)) {
            $sth = $this->pdo->prepare("insert into t_browse (user_, corp, time_, browse) values (:user, :corp, sysdate(), 1)");
            $success = $sth->execute(array('user' => $_SESSION['user']->id, 'corp' => $id));
            return $response->withJson($this->getResult($success));
        }
        return $response->withJson($this->getResult(false));
    }

    public function favorite(Request $request, Response $response) {
        $id = $request->getParam('id');
        $action = $request->getParam('action');

        if($id && $action && !is_null($_SESSION['user']->id)) {
            $sth = null;
            if($action == 'add') {
                // 检测是否已存在
                $sql = "select count(1) from t_browse where user_=:user and corp=:corp and favorite=1";
                $sth = $this->pdo->prepare($sql);
                $sth->execute(array('user' => $_SESSION['user']->id, 'corp' => $id));
                $cnt = $sth->fetchColumn();
                if($cnt == 0) {
                    $sth = $this->pdo->prepare("insert into t_browse (user_, corp, time_, favorite) values (:user, :corp, sysdate(), 1)");
                }
            } else {
                $sth = $this->pdo->prepare("delete from t_browse where user_ = :user and corp=:corp and favorite = 1");
            }
            $success = $sth->execute(array('user' => $_SESSION['user']->id, 'corp' => $id));
            return $response->withJson($this->getResult($success));
        }
        return $response->withJson($this->getResult(false));
    }

}