<?php
/*
 * Function ：注销用户，登出后台
 * Author   ：高鑫
 * 
*/

session_start();
if(!isset($_SESSION['user']))
{
?>
<script type="text/javascript">
alert("请先登陆");
location.href = "login.html";
</script>
<?php
}
else{
unset($_SESSION['user']);
?>
<script type="text/javascript">
alert("注销成功");
location.href = "login.html";
</script>
<?php
} 
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
