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
use PDO;
use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;

class BaseController
{
    protected $app;
    protected $pdo;
    public $searchColumns;
    public $table;
    public $tableKeys;
    public $tableKeysCanUpdate;
    public $uniqueKeys;


    public function __construct(ContainerInterface $ci)
    {
        $this->app = $ci;
        $this->pdo = $ci->db;
    }

    /**
     * 查询列表
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function list(Request $request, Response $response)
    {
        $page = $request->getParam('page');
        $pageSize = $request->getParam('pageSize');
        $search = $request->getParam("search_key");
        $json = $request->getParam("search_column");

        $params = [];
        $sql = "select * from $this->table  ";
        $totalSql = "select count(1) as total from $this->table";

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


    /**
     * 新增或者更新
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response)
    {
        $id = $request->getParam('id');
        if (!is_null($id)) {
            // 更新
            if (count($this->tableKeysCanUpdate) > 0) {
                // 检查唯一值
                if(count($this->uniqueKeys) > 0) {
                    foreach ($this->uniqueKeys as $column) {
                        $value = $request->getParam($column);
                        if(isset($value)) {
                            $checkSql = "select count(1) from $this->table where `id` != :id and `$column` = :$column";
                            $sth = $this->pdo->prepare($checkSql);
                            $sth->execute(['id' => $id, $column => $value]);
                            if($sth->fetchColumn() > 0) {
                                return "值 $value 重复！";
                            }
                        }
                    }

                }

                $sql = "update $this->table set";
                $params = [];
                foreach ($this->tableKeysCanUpdate as $column) {
                    $value = $request->getParam($column);
                    if (isset($value)) {
                        $sql .= " `$column` = :$column, ";
                        $params[$column] = $value;
                    }
                }
                $sql = substr($sql, 0, strlen($sql) - 2);
                $sql .= " where `id` = $id";
                $sth = $this->pdo->prepare($sql);
                $success = $sth->execute($params);
                return $response->withJson($this->getResult($success));
            }

        } else {
            // 新增
            if (count($this->tableKeys) > 0) {
                // 检查唯一值
                if(count($this->uniqueKeys) > 0) {
                    foreach ($this->uniqueKeys as $column) {
                        $value = $request->getParam($column);
                        if(isset($value)) {
                            $checkSql = "select count(1) from $this->table where  `$column` = :$column";
                            $sth = $this->pdo->prepare($checkSql);
                            $sth->execute([$column => $value]);
                            if($sth->fetchColumn() > 0) {
                                return "值 $value 重复！";
                            }
                        }
                    }

                }

                $columns = implode(',', $this->tableKeys);
                $sql = "insert into $this->table ($columns) values (";
                $params = [];
                foreach ($this->tableKeys as $column) {
                    $value = $request->getParam($column);
                    $sql .= " :$column,";
                    $params[$column] = $value;
                }
                $sql = substr($sql, 0, strlen($sql) - 1);
                $sql .= ')';
                $sth = $this->pdo->prepare($sql);
                $success = $sth->execute($params);
                return $response->withJson($this->getResult($success));
            }
        }
    }


    /**
     * 删除
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response)
    {
        $id = $request->getParam('id');
        if (!is_null($id)) {
            $sql = "delete from $this->table where `id` = :id";
            $sth = $this->pdo->prepare($sql);
            $success = $sth->execute(['id' => $id]);
            return $response->withJson($success);
        }
    }

    protected function getResult($success) {
        return $success ? array('code' => 1) : array('code' => 0);
    }

    public function upload(Request $request, Response $response)
    {
        //上传文件名称
        $uploadedFiles = $request->getUploadedFiles();
        if(count($uploadedFiles) == 0) {
            return '';
        }
        $fileNames = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $directory = $_SERVER['DOCUMENT_ROOT']  . '/statics/upload/';
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $fileNames[] = '/statics/upload/'.$filename;
            }
        }
        return $response->withJson($fileNames);

    }

    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        try {
            $basename = bin2hex(random_bytes(8));
        } catch (\Exception $e) {
        } // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}