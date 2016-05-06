<?php

require_once 'SqlTool.php';
$sqlTool = new SqlTool();
$type=$_GET['type'];
$result;
if ($type == 'readDetail'){//添加yue读量
    $id= intval($_GET['id']);
    $result = $sqlTool->query("update article set readNum = readNum + 1 where id = ?",array($id));
    header("Location: article.php?id=".$id);
}elseif ($type == 'showRemark'){
    global $resArray;
    $resArray = array();
    $id = intval($_GET['articleId']);
    $pageNum = 5;
    $pageNow = intval($_GET['pageNow']);
    $offset = ($pageNow - 1) * $pageNum;
    $info=$sqlTool->query("select * from remark where articleId = ? limit $offset,$pageNum" ,array($id));
    while($row = $info->fetch()){
        array_push($resArray,$row);
    }
    echo json_encode($resArray);
}elseif ($type == 'getArticle'){
    $pageNum = 2;
    $resArray = array();
    $pageNow=intval($_GET['pageNow']);
    $info=$sqlTool->listByPage('article',$pageNow,$pageNum,null);
    while($row = $info->fetch()){
        if(strlen(strip_tags($row[3]))> 300){
            $row[3] = mb_substr(strip_tags($row[3]),0,300,'utf-8').".......";
        }
        array_push($resArray,$row);

    }
    echo json_encode($resArray);
}else{//需要检查登录
    require_once 'checkLogin.php';
    if($type == "delete"){//删除操作
        $id= intval($_GET['id']);
        $result = $sqlTool->query("delete from article where id = ?",array($id));
        header("Location:man_article.php");
    }else{
        $type = $_POST['type'];
        $id = $_POST['id'];
        if($type == 'remark'){
            $sqlTool->query("update article set remarkNum = remarkNum + 1 where id = ?",array($id));
            $sql = "insert into remark (remarker,comments,articleId,remarkTime) values ( ?,?,?,?)";
            $remarker = ($_POST['remarker'] == ""?'匿名评论者':$_POST['remarker']);
            $comments = $_POST['comments'];
            $time = date('Y-m-d h:i:s');
            $result = $sqlTool->query($sql,array($remarker,$comments,$id,$time));
            header("Location: article.php?id=".$id);
        }else {//插入或修改文章
            require_once 'upload.php';
            $resImage = upload(array("jpg","gif","bmp","jpeg","png"),'image');
            $resMusic = upload(array("ogg","mp3","wma","wav"),'music');
        //  $resVideo = upload(array("ogg","mp4","avi","rmvb","gif","swf","wmv","mkv"),'video');
            $resVideo = upload(array("ogg","mp4"),'video');
            echo var_dump($resImage) .'<br>'.var_dump($resMusic)."<br>".var_dump($resVideo);
            if($resImage == 1 || $resMusic == 1 || $resVideo == 1){
                echo "文件上传失败<br><a href='javascript:history.go(-1)'>返回上一页</a>";
                exit;
            }elseif ($resImage == 2|| $resMusic == 2 || $resVideo == 1){
                echo "文件类型有误<br><a href='javascript:history.go(-1)'>返回上一页</a>";
                exit;
            }
            $id= intval($_POST['id']);
            $content = $_POST['editor1'];
            $title = $_POST['title'];
            if ($type == NULL && $id == 0){//插入文章
                $reamrkNum = $readNum = 0;
                $time = date('Y-m-d h:i:s');
                $sql = "insert into article (title,releaseDate,content,readNum,remarkNum) values ( ?,?,?,?,?)";
                $sqlTool->query($sql,array($title,$time,$content,$readNum,$reamrkNum));
                $newId =  $sqlTool->lastInsertId();
                $sql = "insert into file (articleId,fileName,fileType) values (?,?,?)";
                echo $newId;
                if($resImage != 3){
                    $sqlTool->query($sql,array($newId,$resImage,'image'));
                }
                if($resMusic != 3){
                    $sqlTool->query($sql,array($newId,$resMusic,'music'));
                }
                if($resVideo != 3){
                    $sqlTool->query($sql,array($newId,$resVideo,'video'));
                }
            }else{//修改文章
                $sql = "update article set title = ?,content = ? where id = ?";
                $result = $sqlTool->query($sql,array($title,$content,$id));
                $sql = "insert into file (articleId ,fileName,fileType) values ( ?, ? , ? )";
                if($resImage != 0){
                    $sqlTool->query("delete from file where fileType = image and articleId = ?",$id);
                    $sqlTool->query($sql,array($id,$resImage,'image'));
                }
                if($resMusic != 0){
                    $sqlTool->query("delete from file where fileType = music and articleId = ?",$id);
                    $sqlTool->query($sql,array($id,$resMusic,'music'));
                }
                if($resVideo != 0){
                    $sqlTool->query("delete from file where fileType = video and articleId = ?",$id);
                    $sqlTool->query($sql,array($id,$resVideo,'video'));
                }
            }
            header("Location:man_article.php");
        }
    }
}
?>