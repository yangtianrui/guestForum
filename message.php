<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, message);
session_start();
require  dirname(__FILE__).'/include/common.inc.php';
if (!isset($_COOKIE['username'])) {
	alert_close('请先登录在执行此操作！');
}
if ($_GET['action'] == 'write'){
	ck_code($_POST['rcode'], $_SESSION['rcode']);
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}'")){
		ck_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
		$_clean['touser'] = $_POST['touser'];
		$_clean['fromuser'] = $_COOKIE['username'];
		$_clean['content'] = ck_content($_POST['content']);
		mysql_str($_clean);
		_query("INSERT INTO g_message (touser,fromuser,content,date) VALUES ('{$_clean['touser']}','{$_clean['fromuser']}','{$_clean['content']}',Now())");
		//写入成功后的操作
		if (_affected() == 1){
			_close();
			session_destroy();
			alert_close('发送成功！');
		}else{
			_close();
			session_destroy();
			alert_close('发送失败，请重试');
		}
	}else{
		alert_close('唯一标识符异常,请不要尝试伪造cookie登录！');
	}
}
if ($_GET['id']){
	//获取数据
	if (!!$row = _fetch_query("SELECT g_username FROM g_user WHERE g_id='{$_GET['id']}'")){
		$in_html['touser'] = $row[g_username];
		$in_html = html_spc($in_html);
	}else{
		alert_close('此用户已被删除或不存在');
	}
}else{
	alert_close('非法操作！');
}
?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>计算机协会-消息发送</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/rcode.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>


<div id="message">
	<h3>发送消息</h3>
	<form action="message.php?action=write" method="POST">
		<input type="hidden" name="touser" value="<?php echo $in_html['touser']; ?>" />
		<dl>
			<dd><input type="text" name="text" class="text" value="To:<?php echo $in_html['touser'];?>" /></dd>
			<dd><textarea name="content"></textarea></dd>
			<dd>验证码:<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"><input type="submit" value="发送" class="submit" /></dd>
		</dl>
	</form>
</div>


</body>
</html>