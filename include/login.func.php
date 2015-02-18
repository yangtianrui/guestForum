<?php 
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}

/**
 * 用于登录界面的用户名验证
 * @param unknown $_str
 * @param unknown $_min
 * @param unknown $_max
 * @return Ambigous <string, unknown, string>
 */
function ck_username_login($_str, $_min, $_max) {
	$_str = trim($_str);
	if (mb_strlen($_str, 'utf-8') < $_min || mb_strlen($_str, 'utf-8') > $_max){
		alert_back('用户名长度错误，请'.$_min.'-'.$_max.'之间取值');//直接调用弹窗函数
	}
	$char_pattern = '/[<>\'\"\ \　]/';//设置不能包含的敏感字符
	if (preg_match($char_pattern, $_str)){
		alert_back('不能包含特殊字符');
	}

	return mysql_str($_str);//对数据进行转译保存，防止sql注入

}

/**
 * 用于登录界面的密码验证
 * @param unknown $sta_psd
 * @param unknown $end_psd
 * @return string
 */
function ck_passwd_login($sta_psd) {
	if (strlen($sta_psd)<6){
		alert_back('密码长度不正确！');
	}

	return sha1($sta_psd);
}


/**
 * 判断时间是否为系统保留，否则弹窗返回
 * @param unknown $_time
 * @return Ambigous <string, unknown, string>
 */
function ck_time_login($_time) {
	$_str = array('0', '1');
	if (!in_array($_time, $_str)){
		alert_back('系统保留方式出错');
	}
	return mysql_str($_time);
}





?>