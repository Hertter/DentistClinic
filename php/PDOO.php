<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/8
 * Time: 8:16
 */

class PDOO {
    private $dbType = 'mysql';
    private $dbName = 'dentist_clinic';
    private $host   = 'localhost';
    private $user   = 'root';
    private $pass   = 'root';
    public  $pdo    = null;//PDO对象
    private $first  = true;//用于拼接字符串时，动态选择是否添加,

    public function __construct (){
        $dsn = $this -> dbType.':host='.$this -> host.';dbname='.$this -> dbName;
        try{
            $this -> pdo = new PDO($dsn, $this -> user, $this -> pass);
        }catch (PDOException $e){
            $error = array(
                'status' => 0,
                'event' => 'connect',
                'errorCode' => $e -> getMessage()
            );
            die(json_encode($error));
        }
    }

    /**
     * 销毁pdo对象
     */
    public function __destruct (){
        $this -> pdo = null;
    }

    /**
     * @param array $allCol      需要查询的所有字段，以数组的形式呈现
     * @param string $tbName     数据表名
     * @param string $expr       条件表达式，例id=1
     * @param int|string $ordCon 排序字段，默认为1，即不根据任何字段进行排序
     * @param bool $desc         是否倒序，true为倒序，false为顺序
     * @return mixed             status->0，查询成功，并返回结果result
     *                           status->2，查询不到
     *                           status->1，查询失败，并返回错误信息errorCode
     */
    public final function fin ($allCol, $tbName, $expr = ' 1 = 1 ', $ordCon = 1, $desc = false){//查询字段的方法
        $columns = null;//用来填充sql语句的字段
        $result = null;//返回结果
        foreach ($allCol as $item => $value) {//将所有的字段依次取出来
            $columns .= ($this -> first) ? $value : ',' . $value;
            $this -> first = false;
        }
        $sql = 'select ' . $columns . ' from ' . $tbName . ' where ' . $expr;
        $sql = ($desc) ? $sql . ' order by ' . $ordCon . ' desc' : $sql . ' order by ' . $ordCon;
//        echo $sql;
        $num = $this -> pdo -> query($sql);//返回受影响的数据条数
        if ($num && $num -> rowCount() > 0) {
            $num -> setFetchMode(PDO::FETCH_ASSOC);
            $rows = $num -> fetchAll();
            foreach ($rows as $item => $row) {
                $result['status'] = 0;//成功状态码为0
                $result['result'][$item] = $row;//将结果返回
            }
        }elseif ($num && 0 === $num -> rowCount()){
            $result['status'] = 2;//执行成功，查询不到结果
        }elseif (!$num){
            $result['status'] = 1;//失败状态码为1
            $result['result'] = implode($this -> pdo -> errorInfo());//返回错误信息
        }
        $this -> first = true;//重置first为true
        return $result;
    }

    /**
     * @param array $allCol  需要插入的字段，格式为['id'=>1,'name'=>'Hertter']
     * @param string $tbName 数据表名
     * @return mixed         'status'->0，成功插入，并返回result，即最后一个id
     *                       'status'->1，插入失败，并返回errorCode，即错误详情
     */
    public final function ins ($allCol, $tbName){//插入字段的方法
        $columns = null;//用来填充sql语句的字段
        $placeHolder = null;//占位符
        $result = array();//返回结果
        foreach ($allCol as $item => $value){//将所有的字段以及值依次取出来
            $columns .= ($this -> first) ? $item : ',' . $item;//将字段拼接起来
            $placeHolder .= ($this -> first) ? ':' . $item : ',:' . $item;//将占位符拼接起来
            $allCol[':' . $item] = $value;//添加新键值对，格式为[':字段名']=>值
            unset ($allCol[$item]);//删除原始的键值对
            $this -> first = false;
        }
        $sql = 'insert into ' . $tbName . '(' . $columns . ') values (' . $placeHolder . ')';
        $stmt = $this -> pdo -> prepare($sql);
        $execute = $stmt -> execute($allCol);
        if ($execute && $stmt->rowCount() > 0){
            $result['status'] = 0;//成功状态码为0
            $result['result'] = $this -> pdo -> lastInsertId();//返回最后一个id
        }elseif (!$execute){
            $result['status'] = 1;//失败状态码为1
            $result['result'] = implode($stmt -> errorInfo());//添加失败，返回错误信息
        }
        $this -> first = true;//重置first为true
        return $result;
    }

    /**
     * @param array $allCol  需要更新的字段，包括字段属性和字段值，例如['grade'=>1,'name'=>'Bod']
     * @param string $tbName 数据表名
     * @param string $expr   查询表达式，例如' id = 1 '
     * @return mixed        'status'->0，更新成功，
     *                        'status'->2，执行成功，但更新失败，可能是因为更新后的值跟原值相同，或者条件表达式不符合
     *                        'status'->3, 执行失败，返回错误信息
     */
    public final function upd ($allCol, $tbName, $expr = ' 1 = 1 '){//更新数据的方法
        $columns = null;//用来填充sql更新语句的execute()方法
        $placeHolder = null;//占位符
        $result = array();//返回结果
        foreach ($allCol as $item => $value){
            $placeHolder .= ($this -> first) ? $item . ' = :'.$item : ', ' . $item . ' = :'.$item;
            $columns[':'.$item] = $value;
            $this -> first = false;
        }
        $sql = 'update ' . $tbName . ' set ' . $placeHolder . ' where ' . $expr;
        $stmt = $this -> pdo -> prepare($sql);
        $execute = $stmt -> execute($columns);
//        $result['sql'] = $sql;
        if ($execute && $stmt -> rowCount() > 0){
            $result['status'] = 0;//成功状态码为0
        }elseif ($execute  &&  0 === $stmt -> rowCount()){
            $result['status'] = 2;//执行成功，但更新失败
        }elseif (!$execute){
            $result['status'] = 1;//失败状态码为1
            $result['result'] = implode($stmt -> errorInfo());//更新失败，返回错误信息
        }
        $this -> first = true;//重置first为true
        return $result;
    }

    /**
     * @param string $tbName  数据表名
     * @param string $expr    条件表达式，例'id = 1'
     * @return mixed         'status'->0，成功删除，并返回删除成功的条数
     *                         'status'->1，删除失败，并返回错误详情
     */
    public final function del($tbName , $expr = ' 1 = 1 '){//删除字段的方法
        $result = array();//返回结果
        $sql = 'delete from ' . $tbName . ' where ' . $expr;
        $num = $this->pdo->exec($sql);
        if ($num > 0){
            $result['status'] = 0;//成功状态码为0
            $result['result'] = $num;//返回成功删除的条数
        }else{
            $result['status'] = 1;//失败状态码为1
            $result['result'] = implode($this -> pdo -> errorInfo());//更新失败，返回错误信息
        }
        return $result;
    }

    public function findCol($col , $tbName , $expr){//查询某个字段是否为空的方法
        //select uName from user where uOpenID = 'oj63q4lpCMM4jPzI2sBPfxBMUsps' and trim(uName) = '';

    }
}