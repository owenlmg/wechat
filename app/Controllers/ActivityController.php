<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


class ActivityController extends BaseController
{
    public $table = 't_activity';
    public $searchColumns = ['name_', 'desc_'];
    public $tableKeys = ['name_', 'desc_', 'url', 'icon', 'is_slide'];
    public $tableKeysCanUpdate = ['name_', 'desc_', 'url', 'icon', 'is_slide'];
    public $uniqueKeys = [];

}