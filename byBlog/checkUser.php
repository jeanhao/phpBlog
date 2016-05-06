<?php
    error_reporting(E_ALL ^ E_NOTICE);
    require'SqlTool.php';
    $sqlTool  = new SqlTool();
    $pageNum = 5;
    if(isset($_GET['pageCount'])){//是否为查询页数

        $result1 = $sqlTool->query("select  count(*) from user");
        $count1 = $result1->fetch();
        $num1 = ceil($count1[0] / $pageNum);
        $result2= $sqlTool->query("select count(*) from user where isValid = 0");
        $count2 = $result2->fetch();
        $num2 = ceil($count2[0] / $pageNum);
        echo "$num1,$num2";
        exit;
    }

    if(isset($_GET['type'])){
        $type = $_GET['type'];
        $id = $_GET['id'];
        require_once ('mailer/mailer.php');
        $result = $sqlTool->query("select email from user where id = ?" , array($id));
        $row = $result->fetch();
        $to = $row[0];
        $subject = '博客相关用户操作';
        $body = '消息提示：';
        if($type == 'enable'){
            $body .= '你的用户已通过审核，能登录本博客系统。';
            $sqlTool->query("update user set isValid = 1 where id = ?" , array($id));
        }elseif ($type == 'disable') {
            $body .= '你的用户未通过审核，相关用户信息会被删除。';
            $sqlTool->query("delete  from  user  where id = ?",array($id));
        }elseif ($type == 'modify') {
            $data = $_GET['data'];
            $body .= '你的用户名已被修改';
            $sqlTool->query("update user set userName  = ? where id = ?",array($data,$id));
        }elseif ($type == 'delete') {
            $body .= '你的用户已被删除';
            $sqlTool->query("delete  from  user  where id = ?",array($id));
        }else{
            echo 'unknown situation';
        }
         echo '操作'.postmail($to,$subject,$body);
        exit;
    }

    $pageNow = intval($_GET['pageNow']) == 0 ? 1 : $_GET['pageNow'];

    $offset =($pageNow - 1 ) * $pageNum;
    $sql = ("select * from user ");
    if(isset($_GET['isValid'])){//是否未查看页面
        $sql .= " where isValid = 0 ";
    }
    $sql .= " limit $offset,$pageNum ";
    $result = $sqlTool->query ($sql);
    $resArray = array();
    $htmlStr = '<tr> <th>用户名</th><th colspan="2">操作</th></tr>';
    while($row = $result->fetch()){
        
        if(isset($_GET['isValid'])){
            $htmlStr .= "<tr><td>".$row['userName']."</td><td>" ; 
            $htmlStr .= "<button class=\"button purple\"  style=\"width:70px\"onclick=\"enable(".$row['id'].")\" >授权</button>";
            $htmlStr .= "</td><td><button class=\"button orange modify".$row['id']."\"  style=\"width:80px\" onclick=\"disable(".$row['id'].")\" >不授权</button></td></tr>";
        }else{
            $htmlStr .= "<tr><td><span class=\"muserName".$row['id']."\">".$row['userName']."</span></td><td><span class=\"mbutton".$row['id']."\">" ; 
            $htmlStr .= "<button  style=\"width:100px\"class=\"button purple modify".$row['id']."\"onclick=\"toModify(".$row['id'].")\" >修改</button></span>";
            $htmlStr .= "</td><td><button style=\"width:70px\" class=\"button orange\" onclick=\"deleteU(".$row['id'].")\">删除</button></td></tr>";
        }
    }
    echo $htmlStr;
?>