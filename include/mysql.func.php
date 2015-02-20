<?php 
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'root');
define('DB_NAME', 'guest');



/**
 * 建立数据库链接
 * @return void
 */

function connect() {
	global $conn;//使这个变量成为全局变量，在函数外部也能访问
	if (!$conn = mysql_connect(DB_HOST, DB_USER, DB_PWD)){
		exit('数据库链接错误！');
	}
}

/**
 * 选择数据库
 * @return void
 */
function select_db() {
	if (!mysql_select_db(DB_NAME)){
		exit('无法选择指定的数据库！');
	}
}

/**
 * 设置字符集
 * @return void
 */
function set_name() {
	if (!mysql_query('SET NAMES UTF8')){
		exit('字符集设置错误！');
	}
}


/**
 * 用php写入sql语句
 * @param string $query
 */
function _query($query) {
	if (!$result = mysql_query($query)){
		exit('sql执行失败！'.mysql_error());
	}
	return $result;
}

/**
 * 从结果集中取出一行作为关联数组,只能获取一条数据组
 * @param string $query
 * @return multitype:
 */
function _fetch_query($query) {
	return mysql_fetch_array(_query($query), MYSQL_ASSOC);
}

/**
 * 返回关联数组的结果集,获取所有数据组
 * @param unknown $result
 * @return multitype:
 */
function _fetch_list($result) {
	return mysql_fetch_array($result, MYSQL_ASSOC);
}

/**
 * 关闭数据库
 */
function _close() {
	if (!mysql_close()){
		exit('数据库关闭错误!');
	}
}

/**
 * 返回影响数据库的条数
 * @return number
 */
function _affected() {
	return mysql_affected_rows();
}





?>