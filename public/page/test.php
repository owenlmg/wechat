<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2019-10-15
 * Time: 15:52
 */

use Wechat\DbCache;

require_once '../../app/Wechat/DbCache.php';
$cache = new DbCache();
//echo "has:";
//var_dump($cache->has('access_token'));
//echo "get:";
//var_dump($cache->get('access_token'));
echo "set:";
$cache->set('access_token',"11223344", 7200);
//echo "get:";
//var_dump($cache->get('access_token'));
//echo "delete:";
//$cache->delete('access_token');
//echo "get:";
//var_dump($cache->get('access_token'));
