<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2019-10-10
 * Time: 12:52
 */
session_start();
session_destroy();
echo 'session已清除';