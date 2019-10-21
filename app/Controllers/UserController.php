<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


class UserController extends BaseController
{
    public $table = 't_user';
    public $searchColumns = ['name_'];
    public $tableKeys = ['name_', 'password', 'openid', 'avatar', 'remark', 'enable'];
    public $tableKeysCanUpdate = ['name_', 'password', 'openid', 'avatar', 'remark', 'enable'];
    public $uniqueKeys = ['openid'];

}