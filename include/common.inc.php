<?php 

if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
define('ROOT_PATH', substr(dirname(__FILE__), 0, -7));
//创建一个判断自动转译是否存在的常量
define('GPC', get_magic_quotes_gpc());

require ROOT_PATH.'\include\global.func.php';


if (PHP_VERSION < '4.0.1'){//控制低版本
	exit('PHP VERSION LOW!');
}
//链接数据库
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'root');
define('DB_NAME', 'guest');
mysql_connect(DB_HOST, DB_USER, DB_PWD) or die("数据库链接失败！");
mysql_select_db(DB_NAME) or die("指定的数据库不存在");
mysql_query('SET NAMES UTF8') or die("字符集选择错误");
//mysql_query('INSERT INTO g_user (g_username) VALUES (11111111)') or die("sql执行失败".mysql_error());

?>
