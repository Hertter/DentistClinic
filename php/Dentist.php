<?php
/**
 * User: Hertter
 * Date: 2020-07-09
 * Time: 23:25
 * Role: 牙医的数据接口
 */

header('Access-Control-Allow-Origin:*');
require_once 'PDOO.php';
date_default_timezone_set('Asia/Shanghai');

class Dentist extends PDOO {

    /**
     * @var null pdo对象
     */
    public $pdo = null;

    public function __construct() {
        parent::__construct();
    }

    /**
     * 销毁pdo对象
     */
    public function __destruct() {
        $this->pdo = null;
    }

    /**
     * 牙医登录
     * @param $username     账号
     * @param $password     密码
     * @return mixed
     */
    public function login($username, $password) {
        $result_find = parent::fin([
            'username',
            'password'
        ], 'doctor',
            ' username = \'' . $username . '\' and password = \'' . $password . '\'');
        if ($result_find['status'] === 0) {
            $result_find['result'] = '登录成功';
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '牙医密码错误';
        }
        return $result_find;
    }

    /**
     * 牙医注册
     * @param $username     账号
     * @param $password     密码
     * @param $sex          性别
     * @param $name         医生姓名
     * @param $location     所属诊所
     * @return mixed
     */
    public function register($username, $password, $sex, $name, $location) {
        $result_find = parent::fin([
            'id'
        ], 'doctor',
            ' username = \'' . $username . '\'');
        if ($result_find['status'] === 0) {
            $result_find['status'] = 2;
            $result_find['result'] = '牙医已经存在';
        } elseif ($result_find['status'] === 2) {
            $result_insert = parent::ins([
                'username' => $username,
                'sex'      => $sex,
                'name'     => $name,
                'location' => $location,
                'password' => $password,
                'profile'  => ''
            ], 'doctor');
            if ($result_insert['status'] === 0) {
                $result_find['status'] = 0;
                $result_find['result'] = '注册成功';
            } elseif ($result_insert['status'] === 1) {
                $result_find['status'] = 1;
                $result_find['result'] = $result_insert['result'];
            }
        }
        return $result_find;
    }

    /**
     * 牙医资料查询
     * @param $username      用户名
     * @return mixed
     */
    public function find($username) {
        $result_find = parent::fin([
            'username',
            'sex',
            'profile',
            'name',
            'location',
            'password'
        ], 'doctor',
            ' username = \'' . $username . '\'');
        if ($result_find['status'] === 2) {
            $result_find['result'] = '查找不到牙医资料';
        }
        return $result_find;
    }

    /**
     * 管理员更新
     * @param $username      账号
     * @param $password      密码
     * @param $sex           性别
     * @param $name          医生姓名
     * @param $location      所属诊所
     * @param $profile       简介
     * @return mixed
     */
    public function update($username, $password, $sex, $name, $location, $profile) {
        $result_find = parent::fin([
            'username'
        ], 'doctor',
            ' username = \'' . $username. '\'');
        if ($result_find['status'] === 0) {
            $result_update = parent::upd([
                'username' => $username,
                'profile'  => $profile,
                'sex'      => $sex,
                'name'     => $name,
                'location' => $location,
                'password' => $password
            ], 'doctor', 'username = \'' . $username . '\'');
            if ($result_update['status'] === 0) {
                $result_find['result'] = '更新成功';
            } else {
                $result_find['status'] = 1;
                $result_find['result'] = $result_update['result'];
            }
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '牙医不存在，更新失败';
        }
        return $result_find;
    }
}

// 实例化对象
$dentist = new Dentist();
// 获取传进来的operate
$function_name = (isset($_POST['operate']) && !empty($_POST['operate'])) ? $_POST['operate'] : die(json_encode(['status' => 1, 'result' => '缺少操作']));
// 账号
$username = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : die(json_encode(['status' => 1, 'result' => '缺少账号']));
// 返回的结果
$result = [];

switch ($function_name){
    case 'login':
        // 密码
        $password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : die(json_encode(['status' => 1, 'result' => '缺少密码']));
        // 方法结果
        $result = $dentist->$function_name($username, $password);
        break;
    case 'register':
        // 密码
        $password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : die(json_encode(['status' => 1, 'result' => '缺少密码']));
        // 性别
        $sex = (isset($_POST['sex']) && !empty($_POST['sex'])) ? $_POST['sex'] : die(json_encode(['status' => 1, 'result' => '缺少性别']));
        // 医生姓名
        $name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : die(json_encode(['status' => 1, 'result' => '缺少姓名']));
        // 所属诊所
        $location = (isset($_POST['location']) && !empty($_POST['location'])) ? $_POST['location'] : die(json_encode(['status' => 1, 'result' => '缺少所属诊所']));
        // 方法结果
        $result = $dentist->$function_name($username, $password, $sex, $name, $location);
        break;
    case 'find':
        // 方法结果
        $result = $dentist->$function_name($username);
        break;
    case 'update':
        // 密码
        $password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : die(json_encode(['status' => 1, 'result' => '缺少密码']));
        // 性别
        $sex = (isset($_POST['sex']) && !empty($_POST['sex'])) ? $_POST['sex'] : die(json_encode(['status' => 1, 'result' => '缺少性别']));
        // 医生姓名
        $name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : die(json_encode(['status' => 1, 'result' => '缺少姓名']));
        // 所属诊所
        $location = (isset($_POST['location']) && !empty($_POST['location'])) ? $_POST['location'] : die(json_encode(['status' => 1, 'result' => '缺少所属诊所']));
        // 简介
        $profile = (isset($_POST['profile']) && !empty($_POST['profile'])) ? $_POST['profile'] : die(json_encode(['status' => 1, 'result' => '缺少简介']));
        // 方法结果
        $result = $dentist->$function_name($username, $password, $sex, $name, $location, $profile);
        break;
    default:
        die(json_encode([
            'status' => 1,
            'result' => '未找到指定的方法.'
        ]));
}

// 返回给客户端
print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
