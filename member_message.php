<?php 
define(IN_CF, true);
define(SCRIPT, member_message);
header("Content-Type:text/html;charset=utf-8;");
require  dirname(__FILE__).'/include/common.inc.php';
//判断是否登录
if (!isset($_COOKIE['username'])) {
	alert_back('请先登录在执行此操作！');
}
//分页函数的准备
page_sta(2, 'SELECT id FROM g_message');
global $pagenum,$pagesize;
$result = _query("SELECT  id,touser,fromuser,content,date FROM g_message ORDER BY date DESC LIMIT $pagenum,$pagesize");
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
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";
?>
<div id="member">
	<?php require ROOT_PATH.'include/sidebar.inc.php';?>
		<div id="main">
			<h2>消息管理</h2>
			<table>
				<tr><th>发信人</th><th>短信内容</th><th>时间</th><th>操作</th></tr>
				<?php while(!!$row = _fetch_list($result)){?>
				<tr><td><?php echo $row['touser']?></td><td style="width: 200px" title="<?php echo $row['content'] ;?> "><a href="message_detail.php?id=<?php echo $row['id']; ?>"><?php echo fix_content($row['content'])?></a></td><td><?php echo $row['date']?></td><td><input type="checkbox" /></td></tr>
				<?php }?>
			</table>
			<?php paging(0)?>
		</div>
</div>
<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>