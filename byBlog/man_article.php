<?php
require_once 'checkLogin.php';
header('Content-Type:text/html;charset=utf-8');
require_once 'SqlTool.php';
$sqlTool = new SqlTool();
$pageNow=isset($_GET['pageNow'])?intval($_GET['pageNow']):1;
$pageNum=5;
$allPageNum = ceil(($sqlTool->conut('article')) / $pageNum);
$result;
if(isset($_GET['keyword'])){//搜索
    $result=$sqlTool->query("select * from article where title like ?",array('%'.$_GET['keyword'].'%'));
}else{//正常查看
    $orderDirection;
    $orderType;
    if(!isset($_GET['orderType'])){
        $orderType = 'id';
        $orderDirection = 1;
    }else{
        $orderType = $_GET['orderType'];
        $orderDirection = $_GET['orderDirection'];
    }
    $result=$sqlTool->listByPage('article', $pageNow, $pageNum,array($orderType,$orderDirection));
}
for($htmlStr = "";$it=$result->fetch();){
    $htmlStr .= '<tr>';
    $htmlStr .= '<td class="tdNum">'.$it[0].'</td>';
    $htmlStr .= '<td>'.$it[1].'</td>';
    $htmlStr .= '<td>'.$it[2].'</td>';
    $htmlStr .= '<td class="tdNum">'.$it[4].'</td>';
    $htmlStr .= '<td class="thButton"><button class="button purple" onclick="edit('.$it[0].')">编辑文章</button></td>';
    $htmlStr .= '<td class="thButton"><button class="button orange" onclick="del('.$it[0].')">删除文章</button></td>';
    $htmlStr .= '</tr>';
}
require 'Smarty_setup.php';
$smarty = new Smarty_setup();
$smarty->assign('htmlStr',$htmlStr);
$smarty->assign('pageNow',$pageNow);
$smarty->assign('allPageNum', $allPageNum);
$smarty->display('resources/html/man_article.html');
?>
