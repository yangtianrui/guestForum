<?php 

if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
define('ROOT_PATH', substr(dirname(__FILE__), 0, -7));
//创建一个判断自动转译是否存在的常量
define('GPC', get_magic_quotes_gpc());

require ROOT_PATH.'\include\global.func.php';
require ROOT_PATH.'include/mysql.func.php';


if (PHP_VERSION < '4.0.1'){//控制低版本
	exit('PHP VERSION LOW!');
}
//链接数据库

connect();
select_db();
set_name();

//消息提醒
//获取未读消息的数目 		count获取指定字段的数目
$message = _fetch_query("SELECT COUNT(id) AS count FROM g_message WHERE state=0 AND touser='{$_COOKIE['username']}'");
if (empty($message['count'])) $in_html_meg = '<b class="read"><a href="member_message.php">(0)</a></b>';
else $in_html_meg = '<b class="noread"><a href="member_message.php">('.$message['count'].')</a></b>';
	








?>
