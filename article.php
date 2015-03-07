<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'article');
require  dirname(__FILE__).'/include/common.inc.php';
if (isset($_GET['id'])) {
	if(!!$row = _fetch_query("SELECT id,username,type,title,content,readcount,commendcount,date FROM g_article WHERE id='{$_GET['id']}'")){
		//阅读数+1
		_query("UPDATE g_article SET readcount=readcount+1 WHERE id='{$_GET['id']}'");
	}else{
		alert_back('不存在文章！');
	}
	//获取发帖人信息
	if(!!$row_user = _fetch_query("SELECT g_id,g_username,g_email,g_face FROM g_user WHERE g_username='{$row['username']}'")) {
		$row_user = html_spc($row_user);
	}else{
		//用户被删除后的处理
		alert_back('此用户已不存在！');
	}
}else{
	alert_back('非法操作');
}
?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>文章列表</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>

<div id="article">
	<h2>文章列表</h2>
	<div id="subject"><!--主题贴部分-->
		<dl>
			<dd class="user"><?php echo $row_user['g_username']; ?></dd>
			<dt><img src="<?php echo $row_user['g_face']; ?>" alt="<?php echo $row_user['g_face;'] ?>" /></dt>
			<dd class="message"><a href="javascript:void(0);" name="message" title="<?php echo $row_user['g_id'] ?>;">发消息</a></dd>
			<dd class="friend"><a href="javascript:void(0);" name="friend" title="<?php echo $row_user['g_id'] ?>;">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:void(0);" name="praise" title="<?php echo $row_user['g_id'] ?>;">给他点赞</a></dd>
			<dd class="email"><a href="mailto:<?php echo $row_user['g_email'] ?>;">邮箱：<?php echo $row_user['g_email'] ?></a></dd>
		</dl>
		<div id="content">
			<div class="user">
				<span class="nav">1#</span>文章来自 ：| <?php echo $row['username']; ?> 发布于 <?php echo $row['date']; ?>
			</div>
			<h3>主题： <?php echo $row['title']; ?><img src="images/icon<?php echo $row['type']; ?>.gif" alt=""></h3>
			<div class="detail">
				<?php echo _ubb($row['content']); ?>
			</div>
			<div id="read">
				阅读数：（<?php echo $row['readcount']; ?>）
				评论数：（<?php echo $row['commendcount']; ?>）
			</div>
		</div>
	</div>
	<p class="line"></p>
</div>

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>