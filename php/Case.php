<?php /** @noinspection ALL */
/**
 * User: Hertter
 * Date: 2020-07-07
 * Time: 17:34
 * Role: 病例的数据接口
 */

header('Access-Control-Allow-Origin:*');
require_once 'PDOO.php';
date_default_timezone_set('Asia/Shanghai');

class IllnessCase extends  PDOO {
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
     * 指定病例查询
     * @return mixed
     */
    public function find($id) {
        $result_find = parent::fin([
            'id',
            'name',
            'sex',
            'born_year',
            'note',
            'status',
            'treatment_plan'
            ], 'illness_case', ' id = ' . $id);
        if ($result_find['status'] === 2) {
            $result_find['result'] = '查询失败';
        }
        return $result_find;
    }

    /**
     * 病例查询
     * @return mixed
     */
    public function query() {
        $result_find = parent::fin([
                'id',
                'name',
                'note'
            ], 'illness_case');
        if ($result_find['status'] === 2) {
            $result_find['result'] = '查询失败';
        }
        return $result_find;
    }

    /**
     * 病例添加
     * @param $name             患者名字
     * @param $sex              患者性别
     * @param $born_year        出生年
     * @param $note             备注
     * @param $status           案例状态
     * @param $treatment_plan   治疗方案
     * @return mixed
     */
    public function add($name, $sex, $born_year, $note, $status, $treatment_plan) {
        $result_insert = parent::ins([
            'name'           => $name,
            'sex'            => $sex,
            'born_year'      => $born_year,
            'note'           => $note,
            'status'         => $status,
            'treatment_plan' => $treatment_plan
        ], 'illness_case');
        if ($result_insert['status'] === 0) {
            $result_insert['status'] = 0;
            $result_insert['result'] = '病例添加成功';
        }
        return $result_insert;
    }

    /**
     * 病例删除
     * @param $id     病例id
     * @return mixed
     */
    public function delete($id) {
        $result_delete = parent::del('illness_case', 'id = ' . $id);
        if ($result_delete['status'] === 0) {
            $result_delete['result'] = '删除成功';
        } elseif ($result_delete['status'] === 1) {
            $result_delete['result'] = '删除失败';
        }
        return $result_delete;
    }

    /**
     * 病例修改
     * @param $id               病例id
     * @param $name             患者名字
     * @param $sex              患者性别
     * @param $born_year        出生年
     * @param $note             备注
     * @param $status           案例状态
     * @param $treatment_plan   治疗方案
     * @return mixed
     */
    public function update($id, $name, $sex, $born_year, $note, $status, $treatment_plan) {
        $result_find = parent::fin(['id'], 'illness_case', ' id = ' . $id);
        if ($result_find['status'] === 0) {
            $result_update = parent::upd([
                'name'           => $name,
                'sex'            => $sex,
                'born_year'      => $born_year,
                'note'           => $note,
                'status'         => $status,
                'treatment_plan' => $treatment_plan
            ], 'illness_case', ' id = ' . $id);
            if ($result_update['status'] === 0) {
                $result_find['result'] = '更新成功';
            } elseif ($result_update['status'] === 1) {
                $result_find['status'] = 1;
                $result_find['result'] = $result_update['result'];
            }else {
                $result_find['status'] = 2;
                $result_find['result'] = '更新失败';
            }
        } elseif ($result_find['status'] === 2) {
            $result_find['result'] = '病例不存在，更新失败';
        }
        return $result_find;
    }
}

// 实例化对象
$case = new IllnessCase();
// 获取传进来的operate
$function_name = (isset($_POST['operate']) && !empty($_POST['operate'])) ? $_POST['operate'] : die(json_encode(['status' => 1, 'result' => '缺少操作']));
// 返回的结果
$result = [];

switch ($function_name){
    case 'query':
        $result = $case->$function_name();
        break;
    case 'update':
        $id             = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : die(json_encode(['status' => 1, 'result' => '缺少id']));
        $name           = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : die(json_encode(['status' => 1, 'result' => '缺少患者名字']));
        $sex            = (isset($_POST['sex']) && !empty($_POST['sex'])) ? $_POST['sex'] : die(json_encode(['status' => 1, 'result' => '缺少患者性别']));
        $born_year      = (isset($_POST['born_year']) && !empty($_POST['born_year'])) ? $_POST['born_year'] : die(json_encode(['status' => 1, 'result' => '缺少出生年']));
        $note           = (isset($_POST['note']) && !empty($_POST['note'])) ? $_POST['note'] : die(json_encode(['status' => 1, 'result' => '缺少备注']));
        $status         = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : die(json_encode(['status' => 1, 'result' => '缺少案例状态']));
        $treatment_plan = (isset($_POST['treatment_plan']) && !empty($_POST['treatment_plan'])) ? $_POST['treatment_plan'] : die(json_encode(['status' => 1, 'result' => '缺少治疗方案']));
        $result = $case->$function_name($id, $name, $sex, $born_year, $note, $status, $treatment_plan);
        break;
    case 'add':
        $name           = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : die(json_encode(['status' => 1, 'result' => '缺少患者名字']));
        $sex            = (isset($_POST['sex']) && !empty($_POST['sex'])) ? $_POST['sex'] : die(json_encode(['status' => 1, 'result' => '缺少患者性别']));
        $born_year      = (isset($_POST['born_year']) && !empty($_POST['born_year'])) ? $_POST['born_year'] : die(json_encode(['status' => 1, 'result' => '缺少出生年']));
        $note           = (isset($_POST['note']) && !empty($_POST['note'])) ? $_POST['note'] : die(json_encode(['status' => 1, 'result' => '缺少备注']));
        $status         = (isset($_POST['status']) && !empty($_POST['status'])) ? $_POST['status'] : die(json_encode(['status' => 1, 'result' => '缺少案例状态']));
        $treatment_plan = (isset($_POST['treatment_plan']) && !empty($_POST['treatment_plan'])) ? $_POST['treatment_plan'] : die(json_encode(['status' => 1, 'result' => '缺少治疗方案']));
        $result = $case->$function_name($name, $sex, $born_year, $note, $status, $treatment_plan);
        break;
    case 'delete' || 'find':
        $id             = (isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : die(json_encode(['status' => 1, 'result' => '缺少id']));
        $result = $case->$function_name($id);
        break;
    default:
        die(json_encode([
                'status' => 1,
                'result' => '未找到指定的方法.'
            ]));
}

// 返回给客户端
print_r(json_encode($result, JSON_UNESCAPED_UNICODE));
