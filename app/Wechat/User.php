<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2019-10-10
 * Time: 10:23
 */

namespace Wechat;
use PDO;
use PDOException;

require '../../vendor/autoload.php';

session_start();


class User
{
    private $db;
    private $link;

    public function __construct()
    {

        $settings = require '../../app/setting.php';
        $this->db = $settings['settings']['db'];

    }

    public function save($user) {
        $this->link = mysqli_connect($this->db['host'], $this->db['username'], $this->db['password'], $this->db['database']);
        mysqli_query($this->link,'set names utf8');
        if (mysqli_connect_errno()) {
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            exit;
        }

        $openid = isset($user->openid) ? $user->openid : "";
        $name = isset($user->nickname) ? $user->nickname : "";
        $sex = isset($user->sex) ? $user->sex : 1;

        $avatar = isset($user->headimgurl) ? $user->headimgurl : "";
        $remark = (isset($user->country) ? $user->country : "").(isset($user->province) ? $user->province : "").(isset($user->city) ? $user->city : "");

        if(isset($user->openid)) {
            $sql = "select * from t_user where openid = '$user->openid'";
            $result = mysqli_query($this->link, $sql);
            if(($row = $result->fetch_object()) != null) {
                $id = $row->id;
                $sql = "update t_user set name_=?,sex=?,openid=?,avatar=?,remark=?,enable=1 where id=$id";
                $stmt = mysqli_prepare($this->link, $sql);
                mysqli_stmt_bind_param($stmt, 'sdsss', $openid, $name, $sex, $avatar, $remark);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $row->name_ = $name;
                $row->sex = $sex;
                $row->avatar = $avatar;
                $row->remark = $remark;
                $row->enable = 1;

                $_SESSION['user'] = $row;
                return $row;
            }
            $sql = "insert into t_user (`name_`, `sex`, `openid`, `avatar`, `remark`, `enable`) values (?, ?, ?, ?, ?, 1)";
            if(($stmt = mysqli_prepare($this->link, $sql))) {
                mysqli_stmt_bind_param($stmt, 'sisss', $name, $sex, $openid, $avatar, $remark);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $id = mysqli_insert_id($this->link);

                $sql = "select * from t_user where id = $id";
                $result = mysqli_query($this->link, $sql);
                if (($row = $result->fetch_object()) != null) {
                    $_SESSION['user'] = $row;
                    return $row;
                }
            }
        }



//        var_dump(mysqli_error($this->link));

        return false;
    }

    public function getUser($openid) {
        $this->link = mysqli_connect($this->db['host'], $this->db['username'], $this->db['password'], $this->db['database']);
        mysqli_query($this->link,'set names utf8');
        if (mysqli_connect_errno()) {
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            exit;
        }
        $sql = "select * from t_user where openid = '$openid'";
        $result = mysqli_query($this->link, $sql);
        if(($row = $result->fetch_object()) != null) {
            $_SESSION['user'] = $row;
            return $row;
        }
        return false;
    }

    public function checkUser($openid)
    {
        $this->link = mysqli_connect($this->db['host'], $this->db['username'], $this->db['password'], $this->db['database']);
        mysqli_query($this->link,'set names utf8');
        if (mysqli_connect_errno()) {
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            exit;
        }
        $sql = "select * from t_user where openid = '$openid'";
        $result = mysqli_query($this->link, $sql);
        if(($row = $result->fetch_object()) != null) {
            $_SESSION['user'] = $row;
            return $row;
        }
        return false;
    }


}