<?php
/*
 * Function �����ݿ������ļ���ʹ��SAE�����MySQL����
 * Author   ������
 * 
*/

	$conn = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
	if(!$conn)
	{
		die("mysql conn failed");
	}
	else{
		mysql_query("set names uft-8");
		mysql_select_db(SAE_MYSQL_DB,$conn);
		if(!$conn)
		{
			die("database selected failed");
		}
	}
?>