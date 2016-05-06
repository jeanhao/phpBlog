<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-Type: text/html;charset=utf-8");
require_once 'checkLogin.php';
$id = isset($_GET['id'])?intval($_GET['id']) :0;
require 'Smarty_setup.php';
$smarty = new Smarty_setup();
if ($id != 0) {
    require_once 'SqlTool.php';
    $sqlTool = new SqlTool();
    $result = $sqlTool->query("select content,title from article where id = ?", array($id));
    $row = $result->fetch();
    if (!$row) {
         echo "<script>alert('不存在id为".$id."的文章')</script>";
    } else {
            $smarty->assign('row', $row);
    }
}
$smarty->display('resources/html/edit_article.html');
