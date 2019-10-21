<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class MessageController extends BaseController
{
    public $table = 't_message';
    public $searchColumns = ['user_', 'content', 'link'];
    public $tableKeys = ['user_', 'content', 'time_', 'link'];
    public $tableKeysCanUpdate = ['user_', 'content', 'time_', 'link'];
    public $uniqueKeys = [];

    public function msg(Request $request, Response $response) {
        if( !is_null($_SESSION['user']->id)) {
            $content = $request->getParam('content');
            $link = $request->getParam('link');
            $sql = "insert into t_message (user_, content, time_, link) values (:user_,:content, now(), :link)";
            $sth = $this->pdo->prepare($sql);
            $success = $sth->execute(array('user_' => 1, 'content' => $content, 'link' => $link));

            return $response->withJson($this->getResult($success));
        }
        return $response->withJson($this->getResult(false));
    }

    public function list(Request $request, Response $response) {
        $page = $request->getParam('page');
        $pageSize = $request->getParam('pageSize');
        $search = $request->getParam("search_key");
        $json = $request->getParam("search_column");

        $params = [];
        $sql = "select $this->table.*,t_user.name_  from $this->table inner join t_user on $this->table.user_=t_user.id ";
        $totalSql = "select count(1) as total from $this->table inner join t_user on $this->table.user_=t_user.id";

        if (!is_null($search) && count($this->searchColumns) > 0) {
            $params['search'] = '%' . $search . '%';
            $sql .= " where (1=0 ";
            $totalSql .= " where (1=0 ";
            foreach ($this->searchColumns as $searchColumn) {
                $sql .= " or `$searchColumn` like :search";
                $totalSql .= " or `$searchColumn` like :search";
            }
            $sql .= "  ) ";
            $totalSql .= "  ) ";
        }
        if (!empty($json)) {
            $sc = json_decode($json);
            if(count($params) == 0) {
                $sql .= " where (1=1 ";
                $totalSql .= " where (1=1 ";
            } else {
                $sql .= " and (1=1 ";
                $totalSql .= " and (1=1 ";
            }

            foreach ($sc as $item => $value ) {
                $sql .= " and `$item` = :$item";
                $totalSql .= " and `$item` = :$item";
                $params[$item] = $value;
            }
            $sql .= "  ) ";
            $totalSql .= "  ) ";
        }
        $sql .= " order by $this->table.id desc";

        if (is_numeric($page) && is_numeric($pageSize)) {
            $offset = ((int)$page - 1) * (int)$pageSize;
            $row = (int)$pageSize;
            $sql .= " limit $offset, $row";
        }

        $result = [];
        $sth = $this->pdo->prepare($totalSql);
        $sth->execute($params);
        $total = $sth->fetchColumn();
        $result['total'] = (int)$total;
        if ($total > 0) {

            $sth = $this->pdo->prepare($sql);
            $sth->execute($params);;
            $rows = $sth->fetchAll(PDO::FETCH_CLASS);
            $result['rows'] = $rows;
        }

        return $response->withJson($result);
    }
}