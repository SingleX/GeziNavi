<?php
/*
 * Function ：后台管理页面：添加站点，编辑站点，管理账户等
 * Author   ：高鑫
 * 
*/
@session_start();
if(!isset($_SESSION['user']))
{
?>
<script type="text/javascript">
	alert("系统提示：请先登录账户！");
	location.href = "login.html";
</script>
<?php
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理 | 格子导航</title>
<style type="text/css">
<!--
body{
	margin:0px; 
	padding:0px; 
	height:100%;
	overflow:hidden; 
	position:relative;
}
a{
	text-decoration:none;
}
#menu{
	position:fixed; 
	z-index: 2; 
	top:10px; 
	left:10px; 
	clear:both; 
	border:1px solid #666; 
	padding:5px; 
	background:#15A230;
}
#menu a{
	margin-left:5px; 
	margin-right:5px;
	color:#FFFFFF;
}
#menu a:hover{
	color:#FF0000;
}
#container{
	position:relative; 
	left:0; 
	width:10000px; 
	top:0; 
	height:100%;
}
#c1,#c2,#c3,#c4{
	width:1500px; 
	height:100%; 
	float:left; 
	margin-right:100px;
}
#c1,#c3 {
	background:#eee;
}
#c2,#c4{
	background:#fff;
}
.content{
	padding:30px 100px;
}
table.tablestyle, td.tbody{
	border:1px #557DBA solid;
	border-collapse:collapse;
}
tr.theader{
	color:#FFFFFF; 
	background:#557DBA; 
	text-align:center;
}
-->
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript">
function validate_required(field,alerttxt){
	with (field){
		if (value==null||value==""){
			alert(alerttxt);
			this.focus();
			return false
		}
		else{ 
			return true 
		}
	}
}
function validate_form(thisform){
	with (thisform){
		if (validate_required(webTitle,"站点名称不能为空！")==false){
			return false;
		}
		if (CheckUrl(webLink.value)==false){
			return false;
		}
		if(upfile.value==""){
			alert("请选择网站logo！");
			return false;
		}
	}
}
function CheckUrl(str){
    var RegUrl = new RegExp();
    RegUrl.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
    if (!RegUrl.test(str)){
		alert("链接网址格式错误！");
		this.focus();
        return false;
    }
    return true;
}
function check_title(thisform){
	with(thisform){
		if (validate_required(webTitle,"站点名称必填")==false){
		return false;
		}
	}
}
function check_link(thisform){
	with(thisform){
		if (CheckUrl(webLink.value)==false){
			return false;
		}
	}
}
function check_Img(thisform){
	with(thisform){ 
		if(upfile.value==""){
			alert("请选择网站logo！");
		return false;
		}
	}
}
function confirmdel(form1){
	with(form1){
		if(confirm("确认删除该网站链接吗？")){ 
			document.form1.submit(); 
		}
	}
	return false; 
}

</script>
</head>
<?php
if(@$_POST['c1'])
{
$id_c="c1";
addWebsite();
?>
<script>alert("网站链接添加成功！");location.href="href.html"</script>
<?php
}
if(@$_GET['edit']=='true')
{
  $id_c="c2";
}
if(@$_POST['c3'])
{
    $id_c="c3";
	if(@$_POST['user_old'] and @$_POST['pw_old'] and @$_POST['user_new'] and @$_POST['pw_new'])
	{
      edit_mima();
	}
	else{
	echo "<script>alert('请填写完整信息！');</script>";
	}
}
?>
<body onLoad="Animate2id('#<?php echo $id_c;?>'); return false;">
<div id="menu">
<a href="#" onClick="Animate2id('#c1'); return false" title="添加站点">添加站点</a>
<a href="#" onClick="Animate2id('#c2'); return false" title="编辑站点">编辑站点</a>
<a href="#" onClick="Animate2id('#c3'); return false" title="修改密码">管理账户</a>
<a href="index.php" target="_blank" title="返回首页">首页</a>
<a href="logout.php" title="注销">注销</a>
</div>
<div id="container">
<div id="c1">
	<div class="content">
<h1>增加站点</h1>
<form name="addWebsite" action="admin.php" method="post" enctype="multipart/form-data" onSubmit="return validate_form(this);">
站点名称 <input name="webTitle" type="text"  />
站点地址 <input name="webLink" type="text" value="http://" /><br/><br/>
站点图片 <input name="upfile" type="file"  /><br/><br/>
<input type="submit" value="添加" name="c1"/>
<input type="reset" value="重写" name="c1"/>
</form>
</div>
</div>
<div id="c2">
	<div class="content">
<h1>编辑站点</h1>
<table class="tablestyle">
	<tr class="theader"><td>站点名称</td><td>站点地址</td><td>站点图片</td><td>更新名称</td><td>更新地址</td><td>更新截图</td><td>删除站点</td></tr>
<?php
require_once("conn.php");
$sql = "select * from web";
$re_total = mysql_query($sql) or die("查询数据库失败");
$total_id = mysql_num_rows($re_total);//总的目录数
$page_size=10;//每页的记录数
$total_page = intval($total_id/$page_size);//取整
if($total_id%$page_size!=0)
{
 $total_page+=1;
}
if(@$_GET['page'] and @$_GET['page']<=$total_page and @$_GET['page']>0)//判断页面的合法性
{
 $current_page=@$_GET['page'];
}
else{
 $current_page=1;
}
$offset = ($current_page-1)*$page_size;//每页显示 x个记录
$sql_current = "select * from web limit $offset,$page_size";
$re_edit = mysql_query($sql_current,$conn) or die("查询数据库失败");
for($i = 1;$i < $total_page+1;$i++)
{
 echo "<a href=admin.php?page=".$i."&edit=true> [".$i."] </a>";
}
echo "<a href=admin.php?page=".($current_page-1)."&edit=true>上一页</a>&nbsp;&nbsp;<a href=admin.php?page=".($current_page+1)."&edit=true>下一页</a><br>";
while($row_edit=mysql_fetch_array($re_edit))
{
	$str = $row_edit['webImg'];
	$strArr = explode('/', $str);
  echo "<tr class=\"tbody\">";
  echo "<td class=\"tbody\">".$row_edit['webTitle']."</td>";
  echo "<td class=\"tbody\"><a href=\"".$row_edit['webLink']."\" target=\"_blank\">".$row_edit['webLink']."</a></td>";
  echo "<td class=\"tbody\"><a href=\"".$row_edit['webImg']."\" target=\"_blank\">".$strArr[3]."</a></td>";
  echo "<td class=\"tbody\"><form name=\"edit_title\" action=\"edit.php\" method=\"post\" onsubmit=\"return check_title(this);\"  ><input name=\"webTitle\" type=\"text\"/><input type=\"submit\" value=\"更新\" name=\"edit_title\"/><input name=\"id\" type=\"hidden\" value=\"".$row_edit['id']."\" /></form></td>";
  echo "<td class=\"tbody\"><form name=\"edit_link\" action=\"edit.php\"  method=\"post\" onsubmit=\"return check_link(this);\" ><input name=\"webLink\" type=\"text\" /><input type=\"submit\" value=\"更新\" name=\"edit_link\"/><input name=\"id\" type=\"hidden\" value=\"".$row_edit['id']."\" /></form></td>";
  echo "<td class=\"tbody\"><form name=\"edit_img\" action=\"edit.php\" method=\"post\"  enctype=\"multipart/form-data\" onsubmit=\"return check_Img(this);\"><input name=\"upfile\" type=\"file\" value=\"选择图片\" /> <input type=\"submit\" value=\"更新\" name=\"edit_img\"/><input name=\"id\" type=\"hidden\" value=\"".$row_edit['id']."\" /> <input name=\"webImg\" type=\"hidden\" value=\"".$row_edit['webImg']."\" /></form></td>";
  echo "<td class=\"tbody\"><form action=\"edit.php\" method=\"post\" onsubmit=\"return confirmdel(this);\"><input type=\"submit\" name=\"edit_delet\" value=\"删除\" /><input name=\"id\" type=\"hidden\" value=\"".$row_edit['id']."\"/><input name=\"webImg\" type=\"hidden\" value=\"".$row_edit['webImg']."\"/></form></td>";
  echo "</tr>";
}
?>
</table>
</div>
</div>
<div id="c3">
	<div class="content">
	<h2>管理账户</h2>
		<form action="admin.php" method="post"> 
		<p>原账号<input name="user_old" /> 原密码<input name="pw_old" type="password"/></p>
		<p>新账号<input name="user_new"/> 新密码<input name="pw_new" type="password"></p>
		<p><input name="c3" value="确认修改" type="submit"></p>
		</form>
	</div>
</div>
</div>
<script>
function Animate2id(id,ease){
	var animSpeed=1500;
	var $container=$("#container");
	if(ease){
		var easeType=ease;
	} else {
    	var easeType="easeOutQuart";
	}
    $container.stop().animate({"left": -($(id).position().left)}, animSpeed, easeType);
}
</script>
</body>
</html>
<?php
//修改密码
function edit_mima()
{
   require_once('conn.php');
   $sql_mima = "select * from user";
   $re=mysql_query($sql_mima);
   $row = mysql_fetch_array($re);
   $user_old = $row['username'];
   $pw_old = $row['password'];
   if($_POST['user_old']==$user_old  and $_POST['pw_old'] = $pw_old)
   {
     $sql_user="update user set username='".$_POST['user_new']."'";
	 $sql_pw="update user set password='".$_POST['pw_new']."'";
	 mysql_query($sql_user) or die("更新账号失败");
     mysql_query($sql_pw) or die("更新密码失败");
	 echo "<script>alert('修改成功!');location.href='logout.php';</script>";
   }
   else{
   echo "原账号或密码填写错误!";
   }
}

// 添加站点的函数
function addWebsite()
{
 require_once('conn.php');
 $webTitle = $_POST['webTitle'];
 $webLink  = $_POST['webLink'];
 $webImg  = uploadImg(2000000);
 $sql = "insert into web(`webTitle`,`weblink`,`webimg`) values('$webTitle','$webLink','$webImg')";
 $re_add = mysql_query($sql,$conn) or die(mysql_error());
}
//网站截图的上传函数
function uploadImg($max_file_size)//返回上传图片的相对路径字符串
{
$stor = new SaeStorage();
$domain = 'gezi';//创建的domain的名称
$url = NULL;
 //上传文件类型列表 
$uptypes=array( 
    'image/jpg', 
    'image/jpeg', 
    'image/png', 
    'image/pjpeg', 
    'image/gif', 
    'image/bmp', 
    'image/x-png' 
);
$max_file_size;     //上传文件大小限制, 单位BYTE  

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if($_FILES["upfile"]["tmp_name"] != NULL)
	{
		$fileDataName = $_FILES["upfile"]["name"];
		//添加图片上传到STORAGE
		$dumpdata = file_get_contents($_FILES["upfile"]["tmp_name"]);
		$dowLoadUrl = $stor->write($domain,$fileDataName,$dumpdata);//用write就行了
		$url = $stor->getUrl($domain,$fileDataName);//如果上传图片的处理地址
		echo " <div id=\"yulan\" ><font color=red>已经成功添加</font><br>"; 
	}
	return $url;//返回上传图片相对地址
}
}
?>