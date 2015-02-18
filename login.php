<?php
header("Content-Type:text/html;charset=utf-8");

define(IN_CF, true);
define(SCRIPT, login);
require  dirname(__FILE__).'/include/common.inc.php';
session_start();
if ($_GET['action'] == 'login.php'){
	exit('已登录！');
}
?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>计算机协会-用户登录</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="./js/login.js"></script>
<script type="text/javascript" src="./js/rcode.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="login">
	<h2>用户登录</h2>
		<form method="post" name="login" action="login.php?action=login.php">
		<dl>
		<dd>用 户    名：<input type="text" name="username" class="text" /></dd>
		<dd>密　　码：<input type="password" name="password" class="text" /></dd>
		<dd>登录状态：保留<input type="radio" name="logined" checked="checked" value="1" />不保留<input type="radio" name="logined" value="0" /></dd>
		<dd>验 证  码：<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></dd>
		<dd><input type="submit" class="button" value="登录" />
			<input type="button" class="button" value="注册" /></dd>
		</dl>
		</form>
</div>
<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>