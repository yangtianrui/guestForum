<?php
/*
 *use_time()  返回当前执行耗时
 *@Access Public 函数公开
 *@return float    返回浮点型 
 */
function use_time() {
	$mtime = explode(' ', microtime());
	return $mtime[0] + $mtime[1];
}
/*
 * 验证码函数
 * @accesss public
 * @param int width 验证码长 	int height 验证码宽	int num 参数个数
 * @return void 无返回值 创建一个验证码
 * */
function rcode($width=70, $height=20, $num=4) {
	for ($i=0;$i<$num;$i++){
		$_nusg .= dechex(mt_rand(0, 15));
	}
	
	$_SESSION['rcode'] = $_nusg;//将变量保存在超全局变量里
	$imgrcode = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($imgrcode, 255, 255, 255);//给图片分配颜色
	$black = imagecolorallocate($imgrcode, 0, 0, 0);
	imagefill($imgrcode, 0, 0, $white);
	//产生六条随机线条
	for ($i=0;$i<5;$i++) {
		$rand_col = imagecolorallocate($imgrcode, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
		imageline($imgrcode, mt_rand(0, $width), mt_rand(0, $height),  mt_rand(0, $width), mt_rand(0, $height), $rand_col);
	}
	//随机打雪花
	for ($i=0;$i<50;$i++) {
		$rand_col = imagecolorallocate($imgrcode, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
		imagestring($imgrcode, 1, mt_rand(0, 255), mt_rand(0, 255), '*', $rand_col);
	}
	//输出验证码
	for($i=0;$i<strlen($_SESSION['rcode']);$i++){
		imagestring($imgrcode, mt_rand(5, 8), ($i*$width/strlen($_SESSION['rcode']))+mt_rand(1, 10), mt_rand(1, $height/3), $_SESSION['rcode'][$i], $black);
	}
	header("Content-Type:image/png");
	imagepng($imgrcode);//将代码输出成图片
	imagedestroy($imgrcode);
}
/**
 *  验证两次验证码是否正确,不正确弹窗
 * @param unknown $sta_code
 * @param unknown $end_code
 */
function ck_code($sta_code, $end_code) {
	if ($sta_code != $end_code){
		alert_back('验证码错误！');
		exit();
	}
}

/**
 * 弹出一个窗口，并且退出php程序
 * @param unknown $str
 */
function alert_back($str) {
	echo "<script>alert('".$str."');history.back()</script>";
	exit();
}

/**
 * 判断php是否开启自动转译
 * @param string $_str
 * @return string|unknown
 */

function mysql_str($_str) {
	if (!GPC){//判断是否开启自动转译
		return mysql_real_escape_string($_str);//将数据进行转译
	}else{
		return $_str;
	}
}



/**
 * 返回一个唯一标识符
 * @param unknown $_str
 * @return unknown
 */

function sha_uniq() {
	return mysql_str(sha1(uniqid(rand(), true)));
	
}

function location_href($str, $url) {
	echo "<script>alert('".$str."');location.href='$url';</script>";
	exit();
}










?>