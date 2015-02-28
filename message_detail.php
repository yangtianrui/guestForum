<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, message_detail);
require  dirname(__FILE__).'/include/common.inc.php';
if (!isset($_COOKIE['username'])){
	alert_back('请先登录！');
}
//删除短信的模块
if ($_GET['action'] == 'delete' && isset($_GET['id'])){
	$id['id'] = mysql_str($_GET['id']);
	$row_del = _fetch_query("select id,touser,fromuser,content,date from g_message where id='{$id['id']}'");
	if ($row_del){
		//删除之前验证唯一标识符
		if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}' LIMIT 1")){
			ck_cookie_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
			_query("DELETE FROM g_message WHERE id={$_GET['id']}");
			if (_affected() == 1){
				_close();
				location_href('删除成功', "member_message.php");
			}else{
				_close();
				alert_back('删除失败，请重试');
			}
		}	
	}else{
		alert_back('此短信不存在！');
	}
}
//通过id的参数来判断短信的内容
if ($_GET['id']){
	$row = _fetch_query("select id,touser,fromuser,content,date,state from g_message where id={$_GET['id']}");
	//更改短信的状态,使成为已读
	if(empty($row['state'])){
		_query("UPDATE g_message SET state=1 WHERE id='{$_GET['id']}' LIMIT 1");
		if(!_affected()) alert_back('未知错误！请重试');
	}
	if ($row){
		$row = html_spc($row);
	}else{
		alert_back('此消息已被删除或不存在！');
	}
}else{
	alert_back('非法操作！');
}
?>
 <!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>消息管理</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<link rel="stylesheet" type="text/css" href="style/1/member.css">
<script type="text/javascript" src="js/message_detail.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="member">
	<?php require ROOT_PATH.'include/sidebar.inc.php';?>
		<div id="main">
			<h2>消息详情</h2>
			<dl>
				<dd>发  信  人:　<?php echo $row['touser'];?></dd>
				<dd>内　　容:　<strong><?php echo $row['content']?></strong></dd>
				<dd>发信时间:　<?php echo $row['date']?></dd>
				<dd class="button"><input type="button" value="返回" id="return" onclick="javascript:location.href="member_message.php";"><input type="button" name="<?php echo $row['id'];?>" id="delete" value="删除"></dd>
			</dl>
		</div>
</div>			

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>








