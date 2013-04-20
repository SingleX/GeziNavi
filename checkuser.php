<?php
/*
 * Function ：用户登录判断
 * Author   ：高鑫
 * 
*/
require_once("conn.php");
$username = $_POST['username'];
$password = $_POST['password'];
$sql_user = 'select * from user';//查询数据库的user表
$re       = mysql_query($sql_user) or die("查询数据库失败!");
while($row = mysql_fetch_array($re))
{
	if($row['username']==$username and $row['password']==$password)
	{
		if(!isset($_SESSION['user']))
		{
		   session_start();
		   $_SESSION['user'] = $username or die('错误');
		}
?>
	<!--登录成功，跳转到管理界面-->
	<script type="text/javascript">
		location.href = "admin.php";
	</script>
<?php
	}
	else
	{
?>
	<!--登录失败，跳回到登录界面-->
	<script type="text/javascript">
		alert("用户名或密码错误！");
		location.href = "login.html";
	</script>
<?php
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>