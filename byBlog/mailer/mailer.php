<?php
  function postmail($to,$subject = '',$body = ''){
    //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    //error_reporting(E_ALL);
    error_reporting(E_STRICT);
    date_default_timezone_set('Asia/Shanghai');//设定时区东八区
    require_once 'class.phpmailer.php' ;
    $mail             = new PHPMailer(); //new一个PHPMailer对象出来

    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug  = 1;                     // 启用SMTP调试功能
    $mail->Host = "smtp.qq.com"; //SMTP服务器 以163邮箱为例子 
    $mail->Port = 25;  //邮件发送端口 
    $mail->SMTPAuth   = true;  //启用SMTP认证 
    $mail->CharSet  = "UTF-8"; //字符集 
    $mail->Encoding = "base64"; //编码方式 
     
    $mail->Username = "793385581@qq.com";  //你的邮箱 
    $mail->Password = "zhfd6112071";  //你的密码 
    $mail->Subject = $subject; //邮件标题 
     
    $mail->From = "793385581@qq.com";  //发件人地址（也就是你的邮箱） 
    $mail->FromName = "博客授权测试";  //发件人姓名 
     
    $mail->AddAddress($to, "用户");//添加收件人（地址，昵称） 
     
    // $mail->AddAttachment('xx.xls','我的附件.xls'); // 添加附件,并指定名称 
    $mail->IsHTML(true); //支持html格式内容 
    // $mail->AddEmbeddedImage("logo.jpg", "my-attach", "logo.jpg"); //设置邮件中的图片 
    $mail->Body = $body;
    return $mail->Send()? '成功':'失败';
}
?>