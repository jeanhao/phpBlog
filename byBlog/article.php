<?php
/**
 * 文章详细查看控制器
 */
 header('Content-Type:text/html;charset=utf-8');
require_once 'SqlTool.php';
$sqlTool = new SqlTool();
$articleId = (isset($_GET['id']) ? intval($_GET['id']) : 1) ;

$rowCount = $sqlTool->query("select count(*) from remark where articleId = ?", array($articleId));
$rowA = $rowCount->fetch();
$pageNum = 5;
$allPageNum = ceil($rowA[0]/$pageNum);

$result = $sqlTool->query("select * from article where id = ?", array($articleId));
$it=$result->fetch();

$htmlStr = "";
$htmlStr .= "<h2>$it[2]</h2>";
$htmlStr .= '<h3 class="title"><a href="/">'.$it[1].'</a></h3>';
$htmlStr .= '<table>';
$sql = "select fileName from file where articleId = ? and fileType = ?";
$image = $sqlTool->query($sql, array($it[0] , 'image'));
$music = $sqlTool->query($sql, array($it[0], 'music'));
$video = $sqlTool->query($sql, array($it[0], 'video'));
if ($ri = $image->fetch()) {
    $htmlStr .= "<p><tr><td>上传图片：</td><td><img src=\"/uploadfile/$ri[0]\" height=\"200\" width=\"300\"></td></tr>";
}
if ($rm = $music->fetch()) {
    $htmlStr .= '<tr><td>上传音乐：</td><td><audio src="/uploadfile/'.$rm[0].'" controls="controls"></audio></td></tr>';
}
if ($rv = $video->fetch()) {
    $htmlStr .= '<tr><td>上传视频：</td><td><video id="video1" width="320" height="240" controls="controls">';
    $htmlStr .= '<source src="/uploadfile/'.$rv[0].'" type="video/ogg">';
    $htmlStr .= '<source src="/uploadfile/'.$rv[0].'" type="video/mp4" > </video></td></tr>';
    $htmlStr .= '<tr><td>视频操作按钮</td><td><button onclick="playPause()">播放/暂停</button>';
    $htmlStr .= '<button onclick="makeBig()">大</button>';
    $htmlStr .= '<button onclick="makeSmall()">小</button></td></tr>';
}
$htmlStr .= "</table></p>";
$htmlStr .= "<p>$it[3]</p>";
$htmlStr .= '<div class="textfoot">阅读量（'.$it[4].' )&nbsp;评论量( '.$it[5].' )</div>';
require_once 'Smarty_setup.php';
$smarty = new Smarty_setup();
$smarty->assign('allPageNum', $allPageNum);
$smarty->assign('htmlStr', $htmlStr);
$smarty->assign('articleId', $articleId);
$smarty->display('resources/html/article.html');
