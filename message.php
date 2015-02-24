<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, message);
require  dirname(__FILE__).'/include/common.inc.php';
if (!isset($_COOKIE['username'])) {
	alert_close('请先登录在执行此操作！');
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
	<form>
		<dl>
			<dd><input type="text" name="text" class="text" value="To:<?php echo $in_html['touser'];?>" /></dd>
			<dd><textarea name="content"></textarea></dd>
			<dd>验证码:<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"><input type="submit" value="发送" class="submit" /></dd>
		</dl>
	</form>
</div>


</body>
</html>