<?php 
session_start();
 ?>
<?php 
define(IN_CF, true);
define(SCRIPT, member_friend);
header("Content-Type:text/html;charset=utf-8;");
require  dirname(__FILE__).'/include/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])) {
	alert_back('请先登录在执行此操作！');
}
//验证添加好友
if ($_GET['action'] == 'check' && isset($_GET['id'])) {
	_query("UPDATE g_friend SET state=1 WHERE id='{$_GET['id']}'");
		if (_affected() == 1){
			_close();
			location_href('好友验证成功', "member_friend.php");
		}else{
			_close();
			location_href('已通过验证！', "member_friend.php");
		}
}
//批量删除好友
if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
	$_clean['ids'] = mysql_str(implode(',', $_POST['ids']));
	
	//删除之前验证唯一标识符
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}' LIMIT 1")){
		ck_cookie_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
		_query("DELETE FROM g_friend WHERE id in ({$_clean['ids']})");
		if (_affected()){
			_close();
			location_href('删除成功', "member_friend.php");
		}else{
			_close();
			alert_back('删除失败，请重试');
		}
	}

}
//分页函数的准备
page_sta(10, "SELECT id FROM g_friend WHERE touser='{$_COOKIE['username']}' OR fromuser='{$_COOKIE['username']}'");
global $pagenum,$pagesize;
$result = _query("SELECT  id,touser,fromuser,content,date,state FROM g_friend WHERE touser='{$_COOKIE['username']}' OR fromuser='{$_COOKIE['username']}' ORDER BY date DESC LIMIT $pagenum,$pagesize");
 ?>
 <!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>好友设置</title>
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
			<h2>好友设置</h2>
			<form method="post" action="?action=delete">
				<table>
					
						<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
						<?php 
							while(!!$row = _fetch_list($result)){
								($row['fromuser'] == $_COOKIE['username']) ? ($in_html['friend'] = $row['touser']) : ($in_html['friend'] = $row['fromuser']);
								if ($row['touser'] == $_COOKIE['username']) {
									if (empty($row['state'])) {
										$in_html['state'] = '<a href="?action=check&id='.$row['id'].'">未验证！</a>';
									}else{
										$in_html['state'] = '验证通过';
									}
								}
								if ($row['fromuser'] == $_COOKIE['username']) {
									if (empty($row['state'])) {
										$in_html['state'] = '<span style="color: #ccc;">对方未验证！<span>';
									}else{
										$in_html['state'] = '验证通过';
									}
								}
						?>
						<tr><td><?php echo $in_html['friend']?></td><td style="width: 200px" title="<?php echo $row['content'] ;?> "><?php echo fix_content($row['content'])?></td><td><?php echo $row['date']?></td><td><?php echo "$in_html[state]"; ?></td><td><input type="checkbox" name="ids[]" value="<?php echo $row['id']?>" /></td></tr><!-- 复选框使用数组传值 -->
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