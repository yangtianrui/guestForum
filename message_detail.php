<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, message_detail);
require  dirname(__FILE__).'/include/common.inc.php';
if (!isset($_COOKIE['username'])){
	alert_back('请先登录！');
}
//通过id的参数来判断短信的内容
if ($_GET['id']){
	$row = _fetch_query("select touser,fromuser,content,date from g_message where id={$_GET['id']}");
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
				<dd>内　　容:　<strong display="block"><?php echo $row['content']?></strong></dd>
				<dd>发信时间:　<?php echo $row['date']?></dd>
				<dd class="button"><input type="button" value="返回" onclick="javascript:history.back();"><input type="button" value="删除""></dd>
			</dl>
		</div>
</div>			

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>








