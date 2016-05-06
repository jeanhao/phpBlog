<?php
    session_start();
    require_once 'Smarty_setup.php';
    $smarty = new Smarty_setup();
    $smarty->assign('errorMsg','');
    if(!isset($_POST['userName'])){//是否为注册或登录请求
        $smarty->display('resources/html/login.html');
    }else{
        require_once 'SqlTool.php';
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $sqlTool = new SqlTool();
        if(!isset($_POST['isRegister'])){//是否为登录请求
            $result = $sqlTool->query("select count(*) from user where userName = ? and password = ? and isValid = 1",array($userName,$password));
            $row = $result->fetch();
            if($row[0] > 0){
                $_SESSION['userName'] = $userName;
                header ("Location: man_article.php");
            }else{
                $smarty->assign('errorMsg',"<script>alert('账号或密码错误或帐号未通过审核')</script>");
                $smarty->display('resources/html/login.html');
            }
        }else{//是否未注册请求
            $result = $sqlTool->query("select count(*) from user where userName = ?",array($userName));
            $count = $result->fetch();
            if($count[0] > 0){
                $smarty->assign('errorMsg',"<script>alert('用户名已存在')</script>");
                $smarty->display('resources/html/login.html');
            }else{
                $email = $_POST['email'];
                //后台校验格式是否正确
                if(!preg_match(" /^\w{5,20}$/",$userName)){
                    $smarty->assign('errorMsg', "<script>alert(用户名格式不正确，必须为5-20个大小写字母/数字或下划线)</script>");
                }
                if(!preg_match('/^[a-zA-Z]\w{4,19}$/',$password)){
                   $smarty->assign('errorMsg', "<script>alert(密码格式不正确，必须以字母开头，长度在6~18之间，只能包含字符、数字和下划线)</script>");
                }
                if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',$email)){
                   $smarty->assign('errorMsg', "<script>alert(邮箱格式不正确)</script>");
                    return ;
                }else{
                    $sqlTool->query("insert into user (userName,password,email,isValid) values (?,?,?,?)",array($userName,$password,$email,0));
                    $smarty->assign('errorMsg',"<script>alert('注册成功，请登录。')</script>");
                }
                $smarty->display('resources/html/login.html');
            }
        }
    }
?>