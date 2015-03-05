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
 * 判断php是否开启自动转译,没有的话转译字符串
 * @param string $_str
 * @return string|unknown
 */

function mysql_str($_str) {
	if (!GPC){//判断是否开启自动转译
		if(is_array($_str)){
			foreach ($_str as $k => $v){
				$_str[$k] = mysql_real_escape_string($v);
			}
		}else{
			$_str = mysql_real_escape_string($_str);
		}
		
	}
	return $_str;
}



/**
 * 返回一个唯一标识符
 * @param unknown $_str
 * @return unknown
 */

function sha_uniq() {
	return mysql_str(sha1(uniqid(rand(), true)));
	
}

/**
 * 跳转到指定的url
 * @param unknown $str
 * @param unknown $url
 */
function location_href($str, $url) {
	echo "<script>alert('".$str."');location.href='$url';</script>";
	exit();
}


/**
 * 删除登录cookie
 */
function _unsetcookie() {
	setcookie('username','', time()-1);//将值设置为空，时间设置为过去，即可删除cookie
	setcookie('uniqid', '', time()-1);
	session_destroy();
	header("Location:index.php");
}

/**
 * 对登录用户的权限进行一些限制
 */
function login_state() {
	if (isset($_COOKIE['username'])){
		alert_back('您已经登录，不能进行此操作！');
	}
}


/**
 * 创建一个分页，无参数或0为数字分页，参数为1 文本分页
 * @param number $type
 */

function paging($type=0) {
	global $page_abs,$pagenow,$page_sum;
	if ($type){//数字分页
		echo '<div id="pagenum">';
		echo '<ul>';
		 for($i=1;$i<$page_abs+1;$i++){
			if ($pagenow == $i){
				echo '<li><a href="'.SCRIPT.'.php?page='.$i.'" class="selected">'.$i.'</a></li>';
			}else{
				echo '<li><a href="'.SCRIPT.'.php?page='.$i.'">'.$i.'</a></li>';
			}
		
			}
			echo '</ul>';
		echo '</div>';

	}else{//文本分页
		echo '<div id="page_text">';
			echo '<ul>';
				echo "<li>$pagenow/".$page_abs."页 |</li>";
				echo "<li>共有<strong>$page_sum</strong>个内容 |</li>";
				if ($pagenow == 1) {
							echo '<li>首页 |</li>';
							echo '<li>上一页 |</li>';
					  } else {//$_SERVER['SCRIPT_NAME']是php环境变量，会返回当前页面的名称,也可使用本页面自定义的常量SCRIPT
					  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page=1">首页</a> |</li>';
					  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.($pagenow-1).'">上一页</a> |</li>';
					  }
					 if ($pagenow == $page_abs) {
							echo '<li>下一页 |</li>';
							echo '<li>尾页 |</li>';
							
					  } else {
					  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.($pagenow+1).'">下一页</a> |</li>';
					  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.$page_abs.'">尾页</a> |</li>';
					  		
				 } 

			echo '</ul>';
		echo '</div>';
	}
}

/**
 * 在分页前进行参数的设置
 * @param int  $size
 * @param string $sql
 */
function page_sta($size, $sql) {
	global $pagenow,$pagesize,$page_sum,$page_abs,$pagenum;//将函数内的变量定义成全局变量，便于函数外部的访问
	if (isset($_GET['page'])){
		$pagenow = $_GET['page'];
		//如果page参数不存在，或者不合法，使初始页面的参数为1
		if (empty($_GET['page']) || $_GET['page'] < 0 || !is_numeric($_GET['page'])){
			$pagenow = 1;
		}else{
			$pagenow = intval($_GET['page']);//对浮点数取整
		}
	}else{
		$pagenow = 1;
	}
	
	$pagesize = $size;
	
	$page_sum = mysql_num_rows(_query($sql));//返回所有搜索结果的字段数
	if ($page_sum == 0){
		$page_abs = 1;//如果数据库中没有数据，默认显示第一页
	}else{
		$page_abs = ceil($page_sum/$pagesize);
	}
	
	if ($pagenow > $page_abs){
		$pagenow = $page_abs;
	}
	$pagenum = ($pagenow-1)*$pagesize;
}

/**
 * 对传入参数进行html过滤，如果是数组遍历后过滤返回
 * @param string or array $wrap
 * @return string
 */

function html_spc($wrap) {
	if (is_array($wrap)){
		foreach ($wrap as $k=>$v){
			$wrap[$k] = htmlspecialchars($v);
		}
	}else{
		$wrap = htmlspecialchars($wrap);
	}
	return $wrap;
}


/**
 * 比对数据库中的唯一标识符与cookie的标识符是否正确，防止伪造cookie登录
 * @param string $sql_uniq
 * @param string $cookie_uniq
 */
function ck_cookie_uniqid($sql_uniq, $cookie_uniq) {
	if ($sql_uniq != $cookie_uniq){
		alert_back('标识符异常！请重试');
	}
}


/**
 * 弹窗并且关闭窗口
 * @param string $str
 */
function alert_close($str) {
	echo "<script>alert('".$str."');window.close();</script>";
	exit();
}

/**
 * 验证唯一标识符是否相等
 * @param unknown $_sta
 * @param unknown $_end
 * @return Ambigous <string, unknown, string>
 */
function ck_uniqid($_sta, $_end) {
	if (($_sta != $_end)){
		alert_back('标识符异常，请刷新后再提交！');
	}
	return mysql_str($_sta);
}
/**
 * 验证消息内容的长度
 * @param unknown $string
 * @return unknown
 */
function ck_content($string) {
	if (mb_strlen($string)<2 || mb_strlen($string)>50){
		alert_close('消息内容不能大于50位小于2位');
	}
	return $string;
}

/**
 * 对content内容取前14个字符 
 * @param unknown $str
 * @return string
 */

function fix_content($str) {
	if (mb_strlen($str, 'utf-8')>16){
		$str = mb_substr($str, 1, 16, 'utf-8').'...';
	}
	return $str;
}

/**
 * 设置xml，用于新进会员, 并且生成特定的xml文件
 * @param resource $handle
 * @param array $clean
 */
function set_xml($handle, $clean) {
	$fp = @fopen($handle, 'w');
	if (!$fp) {
		exit('打开文件错误');
	}
	flock($fp, LOCK_EX);//锁定文件，防止多人同时操作
	
	$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n
		\t<vip>\r\n
			\t<id>{$clean['id']}</id>\r\n
			\t<username>{$clean['username']}</username>\r\n
			\t<sex>{$clean['sex']}</sex>\r\n
			\t<face>{$clean['face']}</face>\r\n
			\t<email>{$clean['email']}</email>\r\n
		\t</vip>";
	fwrite($fp, $str, strlen($str));
	
	flock($fp, LOCK_UN);//解锁文件
	fclose($fp);
}

/**
 * 读取特定的xml文件，并返回一个数组
 * @param resource $xmlfile
 * @return array name $_html
 */

function get_xml($xmlfile) {
	$file = $xmlfile;
	if (file_exists($file)){
		$xml = file_get_contents($file);//将xml读取到文件中
		preg_match_all('/<vip>(.*)<\/vip>/s', $xml, $xml_array);//将xml文件vip下的文件筛选出来，并且返回一个数组
		foreach ($xml_array as $value){
			preg_match_all('/<id>(.*)<\/id>/', $xml, $_id);
			preg_match_all('/<username>(.*)<\/username>/', $xml, $_username);
			preg_match_all('/<sex>(.*)<\/sex>/', $xml, $_sex);
			preg_match_all('/<face>(.*)<\/face>/', $xml, $_face);
			preg_match_all('/<email>(.*)<\/email>/', $xml, $_email);
			$_html['id'] = $_id[1][0];
			$_html['username'] = $_username[1][0];
			$_html['sex'] = $_sex[1][0];
			$_html['face'] = $_face[1][0];
			$_html['email'] = $_email[1][0];
		}
	}else{
		echo '文件不存在！';
	}
	return $_html;
}





//post文章发布页的表单验证

/**
 * 文章标题的验证
 * @param  [type] $min [description]
 * @param  [type] $max [description]
 * @param  [type] $string [description]
 * @return [type]      [description]
 */
function ck_post_title($min, $max, $string) {
	if (mb_strlen($string)<$min || mb_strlen($string)>$max){
		alert_back('标题长度不能大于'.$max.'小于'.$min);
	}
	return $string;
}

/**
 * 文章内容的验证
 * @param  [type] $string [description]
 * @param  [type] $min    [description]
 * @return [type]         [description]
 */
function ck_post_content($string, $min) {
	if (mb_strlen($string)<$min){
		alert_back('内容长度不能小于'.$min);
	}
	return $string;
}

?>