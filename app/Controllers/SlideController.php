<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


class SlideController extends BaseController
{
    public $table = 't_slide';
    public $searchColumns = ['title'];
    public $tableKeys = ['title', 'pic', 'url', 'order', 'enable', 'use'];
    public $tableKeysCanUpdate = ['title', 'pic', 'url', 'order', 'enable', 'use'];
    public $uniqueKeys = ['title'];

}