<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, praise);
session_start();
require  dirname(__FILE__).'/include/common.inc.php';
if (!isset($_COOKIE['username'])) {
	alert_close('请先登录在执行此操作！');
}
if ($_GET['action'] == 'praise'){
	ck_code($_POST['rcode'], $_SESSION['rcode']);
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}'")){
		ck_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
		$_clean['touser'] = $_POST['touser'];
		$_clean['fromuser'] = $_COOKIE['username'];
		$_clean['praise'] = $_POST['praise'];
		$_clean['content'] = ck_content($_POST['content']);

		mysql_str($_clean);
		_query("INSERT INTO g_praise (touser,fromuser,content,date,praise) VALUES ('{$_clean['touser']}','{$_clean['fromuser']}','{$_clean['content']}',Now(),'{$_clean['praise']}')");
		//写入成功后的操作
		if (_affected() == 1){
			_close();
			session_destroy();
			alert_close('点赞成功！');
		}else{
			_close();
			session_destroy();
			alert_close('点赞失败，请重试');
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
<title>点赞</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/rcode.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>


<div id="message">
	<h3>点赞</h3>
	<form action="praise.php?action=praise" method="POST">
		<input type="hidden" name="touser" value="<?php echo $in_html['touser']; ?>" />
		<dl>
			<dd><input type="text" name="text" class="text" readonly="readonly" value="To:<?php echo $in_html['touser'];?>" />
				<select name="praise"><?php foreach (range(1, 10) as $key => $value) {
					echo '<option value="'.$value.'">'.$value.'</option>';
				} ?></select></dd>
			<dd><textarea name="content">点赞，要不要说点什么？</textarea></dd>
			<dd>验证码:<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"><input type="submit" value="确定" class="submit" /></dd>
		</dl>
	</form>
</div>


</body>
</html>