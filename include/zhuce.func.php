<?php 
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
/**
 * 对表单的用户名数据进行过滤
 * @access public
 * @param string $_str
 * @param int $_min
 * @param int $_max
 * @return string
 */
function ck_username($_str, $_min, $_max) {
	$_str = trim($_str);
	if (mb_strlen($_str, 'utf-8') < $_min || mb_strlen($_str, 'utf-8') > $_max){
		alert_back('用户名长度错误，请'.$_min.'-'.$_max.'之间取值');//直接调用弹窗函数
	}
	$char_pattern = '/[<>\'\"\ \　]/';//设置不能包含的敏感字符
	if (preg_match($char_pattern, $_str)){
		alert_back('不能包含特殊字符');
	}
	//限制敏感用户名的注册
	$_mg[0] = 'amdin';
	$_mg[1] ='administrator';
	$_mg[2] ='root';
	if (in_array($_str, $_mg)){
		alert_back('此用户名不能注册');
	}
	return mysql_str($_str);//对数据进行转译保存，防止sql注入

}




/**
 * 验证两次输入密码是否正确，并返回加密 的密码
 * @param string $sta_psd
 * @param string $end_psd
 * @return string
 */
function ck_passwd($sta_psd, $end_psd) {
	if (strlen($sta_psd)<6){
		alert_back('密码长度短，请重设！');
	}
	if ($sta_psd != $end_psd){
		alert_back('两次输入密码不一致！');
	}
	return sha1($sta_psd);
}


/**
 * 处理密码提示问题，并返回值
 * @param string $_str
 * @param int $_min
 * @param int $_max
 * @return string
 */
function ck_ques($_str, $_min, $_max) {
	$_str = trim($_str);
	if (mb_strlen($_str, 'utf-8') < $_min || mb_strlen($_str, 'utf-8') > $_max){
		alert_back('提示问题长度错误，请'.$_min.'-'.$_max.'之间取值');//直接调用弹窗函数
	}
	$char_pattern = '/[<>\'\"\ \　]/';//设置不能包含的敏感字符
	if (preg_match($char_pattern, $_str)){
		alert_back('提示问题不能包含特殊字符');
	}
	return mysql_str($_str);//对数据进行转译保存，防止sql注入
}

/**
 * 提示回答处理函数，加密返回
 * @param string $ans
 * @param string $ques
 * @param int $_min
 * @param int $_max
 * @return string
 */

function ck_ans($ans, $ques, $_min, $_max) {
	$_str = trim($ans);
	if (mb_strlen($ans, 'utf-8') < $_min || mb_strlen($ans, 'utf-8') > $_max){
		alert_back('提示回答长度错误，请'.$_min.'-'.$_max.'之间取值');//直接调用弹窗函数
	}
	if ($ans == $ques){
		alert_back('提示问题与答案不能一样');
	}
	return sha1($ans);
}

/**
 * 判断邮箱格式,并返回
 * @param unknown $email
 * @return unknown
 */
function ck_email($email, $min, $max) {
	if (empty($email)) {//邮件的值可以为空，所以需要提前判断
		return null;
	}else{
		if (!preg_match('/^([\w\-\.]+)(@[\w\-\.]+)\.([\w]{2,4})$/', $email)) {
			alert_back('邮箱格式不正确！');
		}
		if (strlen($email)<$min || strlen($email)>$max){
			alert_back('邮箱长度错误！');
		}
	}
	return mysql_str($email);
}

/**
 * 验证唯一标识符是否相等
 * @param unknown $_sta
 * @param unknown $_end
 * @return Ambigous <string, unknown, string>
 */
function ck_uniqid($_sta, $_end) {
	if ((strlen($_sta) != 40) || ($_sta != $_end)){
		alert_back('标识符异常，请刷新后再提交！');
	}
	return mysql_str($_sta);
}

/**
 * 对性别或头像表单进行转译
 * @param unknown $_sex
 * @return Ambigous <string, unknown, string>
 */
function ck_sex_face($_sex) {
	return mysql_str($_sex);
}




?>