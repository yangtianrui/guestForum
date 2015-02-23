<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'member_modify');
require  dirname(__FILE__).'/include/common.inc.php';
if ($_GET['action'] == 'modify'){
	exit('ok');
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
		$in_html['face_html'] = '<select>';
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
		<form method="POST" action="?action=modify">
		<dl>
			<dd>用 户 名 :　　<?php echo $in_html['username'];?></dd>
			<dd>性　　别:　　<?php echo $in_html['sex'];?></dd>
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