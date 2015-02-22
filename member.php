<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'member');
require  dirname(__FILE__).'/include/common.inc.php';
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
		<h2>个人管理中心</h2>
		<dl>
			<dd>用 户 名</dd>
			<dd>性　　别</dd>
			<dd>注册时间</dd>
			<dd>电子邮箱</dd>
			<dd>头　　像</dd>
			<dd>身　　份</dd>
		</dl>

	</div>
</div>



<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>