<?php 
define(IN_CF, true);
define(SCRIPT, member_message);
header("Content-Type:text/html;charset=utf-8;");
require  dirname(__FILE__).'/include/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])) {
	alert_back('请先登录在执行此操作！');
}
//批量删除短信
if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
	$_clean['ids'] = mysql_str(implode(',', $_POST['ids']));
	
	//删除之前验证唯一标识符
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}' LIMIT 1")){
		ck_cookie_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
		_query("DELETE FROM g_message WHERE id in ({$_clean['ids']})");
		if (_affected()){
			_close();
			location_href('删除成功', "member_message.php");
		}else{
			_close();
			alert_back('删除失败，请重试');
		}
	}

}
//分页函数的准备
page_sta(10, "SELECT id FROM g_message WHERE touser='{$_COOKIE['username']}'");
global $pagenum,$pagesize;
$result = _query("SELECT  id,touser,fromuser,content,date,state FROM g_message WHERE touser='{$_COOKIE['username']}' ORDER BY date DESC LIMIT $pagenum,$pagesize");
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
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";
?>
<div id="member">
	<?php require ROOT_PATH.'include/sidebar.inc.php';?>
		<div id="main">
			<h2>消息管理</h2>
			<form method="post" action="?action=delete">
				<table>
					
						<tr><th>发信人</th><th>消息内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
						<?php 
							while(!!$row = _fetch_list($result)){
								if ($row['state']) {
									$in_html['state'] = '已读';
								}else{
									$in_html['state'] = '<strong>未读</strong>';
								}
						?>
						<tr><td><?php echo $row['fromuser']?></td><td style="width: 200px" title="<?php echo $row['content'] ;?> "><a href="message_detail.php?id=<?php echo $row['id']; ?>"><?php echo fix_content($row['content'])?></a></td><td><?php echo $row['date']?></td><td><?php echo "$in_html[state]"; ?></td><td><input type="checkbox" name="ids[]" value="<?php echo $row['id']?>" /></td></tr><!-- 复选框使用数组传值 -->
						<?php }?>
						<tr><td colspan="5"><label for="ckall">全选<input type="checkbox" name="ckall" id="ckall" /></label><input type="submit" value="批量删除" class="submit" /></td></tr>
					
				</table>
			</form>
			<?php paging(0)?>
		</div>
</div>
<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>