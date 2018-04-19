<?php

namespace app\controller;

use app\Controller;
use pms\Output;

/**
 *  测试控制器
 * Class Demo
 * @package app\controllers
 */
class Demo extends Controller
{
    public function index()
    {
        $this->send([
            "msg" => '我是邮件服务!'
        ]);
    }

}