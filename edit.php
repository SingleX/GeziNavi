<?php
/*
 * Function ：后台编辑更新各项功能：名称，网站，图片，删除
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
if(@$_POST['edit_title'])
{
  updatetitle($_POST['id']);
}
if(@$_POST['edit_link'])
{
updatelink($_POST['id']);
}
if(@$_POST['edit_img'])
{
updateimg($_POST['webImg'],$_POST['id']);
}
if(@$_POST['edit_delet'])
{
delectsite($_POST['webImg'],$_POST['id']);
}
}
?>
<?php
//以下是函数
function delectsite($img_old,$idex)
{
  require_once('conn.php');
  if(file_exists($img_old)){
   unlink($img_old);//删掉原来的图片来节省空间
  }
  $sql="delete from web where id='".$idex."'";
  $re_del=mysql_query($sql,$conn) or die('删除失败');
   mysql_close($conn);
?>
 <script> alert("删除成功");location.href="admin.php?edit=true"; </script>
<?php
return;
}
function updatetitle($idex)//更新标题
{
  require_once('conn.php');
  $updated = $_POST['webTitle'];
  $sql = "update web set webTitle='".$updated."' where id='".$idex."'";
  mysql_query($sql,$conn) or die(mysql_error());
  mysql_close($conn);
  ?>
 <script> alert("更新成功");location.href="admin.php?edit=true"; </script>
 <?php
  return;
}
function updatelink($idex)//更新link
{
  require_once('conn.php');
  $updated = $_POST['webLink'];
  $sql = "update web set webLink='".$updated."' where id='".$idex."'";
  mysql_query($sql,$conn) or die(mysql_error());
  mysql_close($conn);
  ?>
 <script> alert("更新成功");location.href="admin.php?edit=true"; </script>
 <?php
  return;
}
function updateimg($img_old,$idex)
{
  $updateimg = uploadImg(2000000);//上限单位为比特
  if(file_exists($img_old)){
   unlink($img_old);//删掉原来的图片来节省空间
  }
  require_once('conn.php');
  $sql = "update web set webImg='".$updateimg."' where id='".$idex."'";//更新图片的数据库记录
  mysql_query($sql,$conn) or die("更新失败");
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
		$dowLoadUrl = $stor->write($domain,$fileDataName,$dumpdata);//用write
		$url = $stor->getUrl($domain,$fileDataName);//如果上传图片的处理地址
		echo " <div id=\"yulan\" ><font color=red>已经成功更新</font><br>"; 
	}
	return $url;//返回上传图片相对地址
} 
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head></html>