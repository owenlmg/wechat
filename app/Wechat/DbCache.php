<?php

namespace Wechat;

require '../../vendor/autoload.php';


class DbCache
{
    private $db;
    private $link;
    private $table = 't_cache';

    public function __construct()
    {

        $settings = require '../../app/setting.php';
        $this->db = $settings['settings']['db'];

        $this->link = mysqli_connect($this->db['host'], $this->db['username'], $this->db['password'], $this->db['database']);
        mysqli_query($this->link,'set names utf8');
        if (mysqli_connect_errno()) {
            echo "errno: " . mysqli_connect_errno() . PHP_EOL;
            exit;
        }
    }


    /**
     * 根据key获取值，会判断是否过期
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $sql = "select * from $this->table where key_ = '$key'";
        if($result = mysqli_query($this->link, $sql)) {
            if($row = $result->fetch_object()) {
                mysqli_free_result($result);
                if($row->expire_ > 0 && ($row->time + $row->expire_) < time()) {
                    $this->delete($key);
                    return false;
                }
                return $row->value_;
            }
        }
        return false;
    }

    /**
     * 添加或覆盖一个key
     * @param $key
     * @param $value
     * @param $expire
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        $sql = "select * from $this->table where key_ = '$key'";
        if($result = mysqli_query($this->link, $sql)) {
            if($row = $result->fetch_object()) {
                $sql = "update $this->table set value_ = ?, time_ = unix_timestamp(), expire_ = ? where key_ = ?";
                $stmt = mysqli_prepare($this->link, $sql);
                mysqli_stmt_bind_param($stmt, 'sis', $value, $expire, $key);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                $sql = "insert into $this->table (key_, value_, time_, expire_) values (?, ?, unix_timestamp(), ?)";
                $stmt = mysqli_prepare($this->link, $sql);
                echo mysqli_error($this->link);
                mysqli_stmt_bind_param($stmt, 'ssi', $key, $value, $expire);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            mysqli_free_result($result);
        }
    }

    /**
     * 判断Key是否存在
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        $sql = "select count(1) as cnt from $this->table where key_ = '$key'";
        if($result = mysqli_query($this->link, $sql)) {
            if($row = $result->fetch_object()) {
                return $row->cnt > 0;
            }
        }
        return false;
    }

    /**
     * 删除一个key，同事会删除缓存文件
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        if($this->has($key)) {
            $sql = "delete from $this->table where key_ = ?";
            $stmt = mysqli_prepare($this->link, $sql);
            mysqli_stmt_bind_param($stmt, 's', $key);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    /**
     * 清楚所有缓存
     * @return mixed
     */
    public function flush()
    {
        $sql = "delete from $this->table";
        $stmt = mysqli_query($this->link, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}