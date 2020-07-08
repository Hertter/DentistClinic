<?php
/**
 * User: Hertter
 * Date: 2020-07-07
 * Time: 16:38
 * Role: 测试请求专用
 */

if (!empty($_POST))
    print_r(json_encode(['status' => 0, 'result' => 'Post请求测试成功', '_Post' => $_POST]));
elseif (!empty($_GET))
    print_r(json_encode(['status' => 0, 'result' => 'Get请求测试成功', '_Get' => $_GET]));
else
    print_r(json_encode(['status' => 0, 'result' => '无参请求测试成功']));