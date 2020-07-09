<?php /** @noinspection ALL */
/**
 * User: Hertter
 * Date: 2020-07-06
 * Time: 16:34
 * Role: 管理员的数据接口
 */

header('Access-Control-Allow-Origin:*');
require_once 'PDOO.php';
date_default_timezone_set('Asia/Shanghai');

class Admin extends PDOO {

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
     * 管理员登录
     * @param $username     用户名
     * @param $password     用户密码
     * @return mixed
     */
    public function login($username, $password) {
        $result_find = parent::fin([
                'username',
                'password'
            ], 'admin',
            ' username = \'' . $username . '\' and password = \'' . $password . '\'');
        if ($result_find['status'] === 0) {
            $result_find['result'] = '登录成功';
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '用户不存在';
        }
        return $result_find;
    }

    /**
     * 管理员注册
     * @param $username     用户名
     * @param $password     用户密码
     * @return mixed
     */
    public function register($username, $password) {
        $result_find = parent::fin([
            'id'
        ], 'admin',
            ' username = \'' . $username . '\'');
        if ($result_find['status'] === 0) {
            $result_find['status'] = 2;
            $result_find['result'] = '用户名已经存在';
        } elseif ($result_find['status'] === 2) {
            $result_insert = parent::ins([
                'username' => $username,
                'password' => $password
            ], 'admin');
            if ($result_insert['status'] === 0) {
                $result_find['status'] = 0;
                $result_find['result'] = '注册成功';
            }
        }
        return $result_find;
    }

    /**
     * 管理员删除
     * @param $username      用户名
     * @param $password      用户密码
     * @return mixed
     */
    public function delete($username, $password) {
        $result_find = parent::fin([
            'username',
            'password'
        ], 'admin',
            ' username = \'' . $username . '\' and password = \'' . $password . '\'');
        if ($result_find['status'] === 0) {
            $result_delete = parent::del('admin', 'username = ' . $username);
            if ($result_delete['status'] === 0) {
                $result_find['result'] = '删除成功';
            } else {
                $result_find['status'] = 1;
                $result_find['result'] = $result_delete['result'];
            }
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '用户信息有误';
        }
        return $result_find;
    }

    /**
     * 管理员更新
     * @param $username      用户名
     * @param $password      用户密码
     * @param $new_password  新的用户密码
     * @return mixed
     */
    public function update($username, $password, $new_password) {
        $result_find = parent::fin([
            'username',
            'password'
        ], 'admin',
            ' username = \'' . $username . '\' and password = \'' . $password . '\'');
        if ($result_find['status'] === 0) {
            $result_update = parent::upd([
                'username' => $username,
                'password' => $new_password
            ], 'admin', 'username = ' . $username);
            if ($result_update['status'] === 0) {
                $result_find['result'] = '更新成功';
            } else {
                $result_find['status'] = 1;
                $result_find['result'] = $result_update['result'];
            }
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '用户不存在，更新失败';
        }
        return $result_find;
    }
}

// 实例化对象
$admin = new Admin();
// 获取传进来的operate
$function_name = (isset($_POST['operate']) && !empty($_POST['operate'])) ? $_POST['operate'] : die(json_encode(['status' => 1, 'result' => '缺少操作']));
// 用户名
$username = (isset($_POST['username']) && !empty($_POST['username'])) ? $_POST['username'] : die(json_encode(['status' => 1, 'result' => '缺少用户名']));
// 用户密码
$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : die(json_encode(['status' => 1, 'result' => '缺少密码']));
// 返回的结果
$result = [];

switch ($function_name){
    case 'login' || 'register' || 'delete':
        // 方法结果
        $result = $admin->$function_name($username, $password);
        break;
    case 'update':
        // 新的用户密码
        $new_password = (isset($_POST['new_password']) && !empty($_POST['new_password'])) ? $_POST['new_password'] : die(json_encode(['status' => 1, 'result' => '缺少新密码']));
        // 方法结果
        $result = $admin->$function_name($username, $password, $new_password);
        break;
    default:
        die(json_encode([
                'status' => 1,
                'result' => '未找到指定的方法.'
            ]));
}

// 返回给客户端
print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
