<?php
/**
 * Sql工具类
 */
class SqlTool{
private $pdo;
private $user = 'zenghao';
private $password = 'zhfd6112071';
private $database = 'byblog';

public function __construct(){
    $this->pdo = $db = new PDO('mysql:host=localhost;dbname='.$this->database, $this->user, $this->password);
    $this->pdo->exec('set names utf8');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

public function lastInsertId(){
    return $this->pdo->lastInsertId();
}
public function prError($exception){
    echo 'PDO Exception Caught.';
    echo 'Error with the database:<br />';
    echo '<pre>';
    echo "Error: ".$exception->getMessage()."<br />";
    echo "Code: ".$exception->getCode()."<br />";
    echo "File: ".$exception->getFile()."<br />";
    echo "Line: ".$exception->getLine()."<br />";
    echo "Trace: ".$exception->getTraceAsString()."<br />";
    echo '</pre>';
}
public function query($sql){
    $numargs = func_num_args();
    if($numargs > 1){
        $args = func_get_args();
    }
    $valArray = $args[1];
    try{
        $result = $this->pdo->prepare($sql);

        for($i = 0;$i < count($valArray);$i++){
            $result->bindParam(($i+1),$valArray[$i]);
        }
        $result->execute();
    }catch(PDOException $exception){
        $this->prError($exception);
    }
    return $result;
}
public function conut($object){
    $res = $this->pdo->query('select count(*) from '.$object);
    $count = $res->fetch();
    $total = $count[0];
    return $total;
}
public function listByPage($object,$pageNow,$pageNum,$typeArray){
    $result;
    try {
        $offset=($pageNow-1)*$pageNum;         //获取limit的第一个参数的值 offset
        if($typeArray){
            $direction = ($typeArray[1] % 2 == 0 ? 'desc' : 'asc');
            $sql = "select * from ".$object." order by ".$typeArray[0]." ".$direction." limit ".$offset.",".$pageNum;
            $result = $this->pdo->query($sql);   //获取相应页数所需要显示的数据
        }else{
            $sql = "select * from ".$object." limit ".$offset.",".$pageNum;
            $result = $this->pdo->query($sql);
        }
    }catch (PDOException $exception){
        $this->prError($exception);
    }
    $this->pdo = null;
    return $result;
}

public function execute($sql){
    $numargs = func_num_args();
    if($numargs > 1){
        $args = func_get_args();
    }
    $valArray = $args[1];
    $result = $this->pdo->prepare($sql);
    for($i = 0;$i < count($valArray);$i++){
        $this->result->bindParam($i,$valArray[$i]);
    }
    try{
        $res = $result->execute();
    }catch (PDOException $exception){
        $this->prError($exception);
    }
    $this->pdo = null;
    return $res;
}
}
?>