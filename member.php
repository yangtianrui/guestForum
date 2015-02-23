<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'member');
require  dirname(__FILE__).'/include/common.inc.php';
//阻止用户直接登录
if (isset($_COOKIE['username'])){
	$rows = _fetch_query("SELECT g_username,g_sex,g_face,g_level,g_email,g_reg_time FROM g_user WHERE g_username='{$_COOKIE['username']}'");
	if ($rows){
		$in_html['username'] = $rows['g_username'];
		$in_html['sex'] = $rows['g_sex'];
		$in_html['face'] = $rows['g_face'];
		$in_html['email'] = $rows['g_email'];
		$in_html['reg_time'] = $rows['g_reg_time'];
		$rows['g_level'];
		switch ($rows['g_level']){
			case 1 :
				$in_html['level'] ='管理员' ;
				break;
			case 0 :
				$in_html['level'] = '会员';
		}	
		$in_html = html_spc($in_html);
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
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="member">
	<?php require ROOT_PATH.'include/sidebar.inc.php';?>
	<div id="main">
		<h2>个人信息</h2>
		<dl>
			<dd>用 户 名 :　　<?php echo $in_html['username'];?></dd>
			<dd>性　　别:　　<?php echo $in_html['sex'];?></dd>
			<dd>注册时间:　　<?php echo $in_html['reg_time'];?></dd>
			<dd>电子邮箱:　　<?php echo $in_html['email'];?></dd>
			<dd>头　　像:　　<?php echo $in_html['face'];?></dd>
			<dd>身　　份:　　<?php echo $in_html['level'];?></dd>
		</dl>

	</div>
</div>



<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>