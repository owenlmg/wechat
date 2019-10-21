<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


class CorpController extends BaseController
{
    public $table = 't_corp';
    public $searchColumns = ['name_', 'sd', 'desc_', 'mobile', 'phone', 'address'];
    public $tableKeys = ['type_', 'name_', 'sd', 'logo', 'desc_', 'pics', 'mobile', 'phone', 'address', 'remark'];
    public $tableKeysCanUpdate = ['type_', 'name_', 'sd', 'logo', 'desc_', 'pics', 'mobile', 'phone', 'address', 'remark'];
    public $uniqueKeys = ['name_'];

}