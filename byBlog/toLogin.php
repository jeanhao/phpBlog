<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
<meta http-equiv="description" content="This is my page">
<link rel="stylesheet" type="text/css" href="resources/css/buttons.css">
</head>
<?php 
	if(isset($_SESSION['errorMsg'])){
		echo $_SESSION['errorMsg'];
	}
?>
<body background="resources/images/main.jpg">
<form action="login.php" method="post">
<table
	style="margin: 0 auto; position: relative; top: 250px; background-color: yellow">
	<tr>
		<th colspan="2">用户登录</th>
	</tr>
	<tr>
		<td>账号：</td>
		<td><input type="text" name="userName" placeholder="用户名"></td>
	</tr>
	<tr>
		<td>密码：</td>
		<td><input type="password" name="password" placeholder="密码"></td>
	</tr>
	<tr>
		<td><input type="submit" class="button purple" value="提交"></td>
		<td><input type="reset" class="button green" value="重置"></td>
	</tr>
</table>
</form>
</body>
</html>
<?php ?>