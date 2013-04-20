<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!doctype html> 
<head>
	<title>格子导航</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	<script language="javascript">
	$(document).ready(function() {
	//页面渐显载入
	$("#body_div").hide();
	$("#body_div").fadeIn(1500);
	});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			//使用fancybox弹出自定义iframe
			$("#add_site, #about").fancybox({
				'width'				: '60%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
	});
	</script>
</head>
<body>
	<div id="body_div">
		<div class="top">
			<div class="title"><a href="http://gezi.sinaapp.com"><img src="images/logo.png" /></a></div>
			<div class="info">
				<div id="path_times"><a href="about.html" id="about">关于格子</a></div>
				<div id="weibo"><a href="http://v.t.sina.com.cn/share/share.php?title=我刚刚使用了格子导航（http://gezi.sinaapp.com/），好看又实用，分享给大家！快去看一看吧！" target="_blank" >分享到微博</a></div>
			</div>
		</div>
		<hr/><br/><br/>
		
<?php
	require_once('conn.php');//包含数据库连接配置文件
	$sql = "select * from web order by id";//查询数据库
	$re  = mysql_query($sql) or die("连接数据库错误");
	$somevar = 0;
	while($row = mysql_fetch_array($re))
	{
		$somevar++;
		$array[$somevar] = $row;
	}
	for($i = 1;$i<=$somevar;$i++)
	{
		//循环数组查询每列的值
		$col=$array[$i];
		if($i>1)
		{
			if($i % 10 == 1)
			{
				echo "</ul>";
				echo "</div><div>";
				echo "<div id=\"content\">";
				echo "<div id=\"menu\" class=\"menu\">";
				echo "<ul>";
			}
			echo "<li><a href=\"".$col['webLink']."\" class=\"websites\" target=\"_blank\"><img src=\"".$col['webImg']."\" /></a>";
		}
		else
		{
			echo "<div id=\"content\">";
			echo "<div id=\"menu\" class=\"menu\">";
			echo "<ul>";
			echo "<li><a href=\"".$col['webLink']."\" class=\"websites\" target=\"_blank\"><img src=\"".$col['webImg']."\" /></a>";
		}
	}
?>
			</ul>
		</div>
	</div>
	<div align="center" class="footer">
		©2013 格子导航 · 版权所有<br/>
		<a href="http://sae.sina.com.cn" target="_blank"><img src="images/sae_logo.png" /></a>
	</div>
	<div class="hidden">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fdd95811801ccc05b2c4a55406aad65fe' type='text/javascript'%3E%3C/script%3E"));
</script>
	</div>
</body>
</html>