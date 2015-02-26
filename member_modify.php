<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'member_modify');
session_start();
require  dirname(__FILE__).'/include/common.inc.php';
if ($_GET['action'] == 'modify'){
	ck_code($_POST['rcode'], $_SESSION['rcode']);
	//判断要修改的数据是否存在
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}' LIMIT 1")){
		//比对唯一标识符，防止伪造cookie
		ck_cookie_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
	
		include ROOT_PATH.'include/zhuce.func.php';
		$_clean = array();
		$_clean['password'] = ck_modify_pwd($_POST['password'], 6);
		$_clean['face'] = ck_sex_face($_POST['face']);
		$_clean['email'] = ck_email($_POST['email'], 2, 40);
		//提交数据
		if (empty($_clean['password'])){
			_query("UPDATE g_user SET g_face='{$_clean['face']}',g_email='{$_clean['email']}' WHERE g_username='{$_COOKIE['username']}'");
		}else{
			_query("UPDATE g_user SET g_password='{$_clean['password']}',g_face='{$_clean['face']}',g_email='{$_clean['email']}' WHERE g_username='{$_COOKIE['username']}'");
		}
		//修改成功的话跳转
		if (_affected() == 1){
			_close();
			session_destroy();
			location_href('修改成功', "member.php");
		}else{
			_close();
			session_destroy();
			location_href('没有任何修改', 'member_modify.php');
		}
	}
}
//阻止用户直接登录
if (isset($_COOKIE['username'])){
	$rows = _fetch_query("SELECT g_username,g_sex,g_face,g_email FROM g_user WHERE g_username='{$_COOKIE['username']}'");
	if ($rows){
		$in_html['username'] = $rows['g_username'];
		$in_html['sex'] = $rows['g_sex'];
		$in_html['face'] = $rows['g_face'];
		$in_html['email'] = $rows['g_email'];
		$in_html = html_spc($in_html);
		//头像选择
		$in_html['face_html'] = '<select name="face">';
		//使用foreach进行循环，先用range创建一个数组
		foreach (range(1, 9) as $num){
			$in_html['face_html'] .='<option value="face/m0'.$num.'.gif">face/m0'.$num.'.gif</option>';
		}
		foreach (range(10, 64) as $num){
			$in_html['face_html'] .='<option value="face/m'.$num.'.gif">face/m'.$num.'.gif</option>';
		}
		$in_html['face_html'] .= '</select>';
		
	}else{
		alert_back('此用户不存在！');//防止伪造cookie登录

	}
	
}else{
	alert_back('请先登录再进入个人中心');
}

?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>博友列表</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/member.js"></script>
<script type="text/javascript" src="js/rcode.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="member">
	<?php require ROOT_PATH.'include/sidebar.inc.php';?>
	<div id="main">
		<h2>修改资料</h2>
		<form method="POST" name="modify" action="?action=modify">
		<dl>
			<dd>用 户 名 :　　<?php echo $in_html['username'];?></dd>
			<dd>性　　别:　　<?php echo $in_html['sex'];?></dd>
			<dd>密　　码:　　<input type="password" name="password" class="text" placeholder="留空则不修改" /></dd>
			<dd>电子邮箱:　　<input name="email" class="text" value="<?php echo $in_html['email'];?>" /></dd>
			<dd>头　　像:　　<?php echo $in_html['face_html'];?></dd>
			<dd>验 证  码：　　<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></dd>
			<dd><input type="submit" value="确定" class="submit" />
				<input type="button" value="重置" class="submit" onclick="javascript:location.href='./member_modify.php'" /></dd>
		</dl>
		</form>
	</div>
</div>



<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>