<?php 
define(IN_CF, true);
define(SCRIPT, active);
header("Content-Type:text/html;charset=utf-8;");
require  dirname(__FILE__).'/include/common.inc.php';
//开始激活处理
if ($_GET['active'] == ''){
	alert_back('非法操作！');
}
if (isset($_GET['action']) && isset($_GET['active']) && ($_GET[action]=='ok')){
	$_active = mysql_str($_GET['active']);
	if (_fetch_query("SELECT g_active FROM g_user WHERE g_active='$_active' LIMIT 1")){
		_query("UPDATE g_user SET g_active=NULL WHERE g_active='$_active' LIMIT 1");
		if (_affected() == 1){
			_close();
			location_href('激活账户成功', 'login.php');
		}else {
			_close();
			location_href('未知错误，请重新注册', 'zhuce.php');
		}
	}else {
		location_href('激活账户成功', 'login.php');
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>计算机协会-用户注册</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/face.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="active">
	<h2>激活帐号</h2>
	<p>请点击下面的链接激活用户</p>
	<P><a href="active.php?action=ok&amp;active=<?php echo $_GET['active'];?>"><?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>?action=ok&amp;active=<?php echo $_GET['active'];?></a></P>
</div>



<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>