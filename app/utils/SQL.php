<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:21
 */

namespace Utils;


class SQL
{
    // 实时排队数量
    const QUEUE = "SELECT COUNT(*) as queueCount FROM CTI_MONITOR_CO WHERE skill_type!='' AND co_state='4e'";



}