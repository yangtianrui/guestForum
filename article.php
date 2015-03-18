<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'article');
session_start();
require  dirname(__FILE__).'/include/common.inc.php';
//回帖处理
if($_GET['action'] == 'rearticle') {
	ck_code($_POST['rcode'], $_SESSION['rcode']);
	//判断唯一标识符
	if (!!$row = _fetch_query("SELECT g_uniqid FROM g_user WHERE g_username='{$_COOKIE['username']}' LIMIT 1")){
		ck_cookie_uniqid($row['g_uniqid'], $_COOKIE['uniqid']);
		$_clean['reid'] = $_POST['reid'];
		$_clean['type'] = $_POST['type'];
		$_clean['username'] = $_COOKIE['username'];
		$_clean['title'] = $_POST['title'];
		$_clean['content'] = $_POST['content'];
		$_clean = mysql_str($_clean);
		//写入数据库
		_query("INSERT INTO g_article (reid,username,title,content,type,date) VALUES ('{$_clean['reid']}','{$_clean['username']}','{$_clean['title']}','{$_clean['content']}','{$_clean['type']}',NOW())");
		if (_affected()){
			_close();
			location_href('回复成功', "article.php?id={$_clean['reid']}");
		}else{
			_close();
			alert_back('回复失败，请重试！');
		}
	}else{
		alert_back('唯一标识符异常！');
	}

}
//读取帖子的处理
if (isset($_GET['id'])) {
	if(!!$row = _fetch_query("SELECT id,reid,username,type,title,content,readcount,commendcount,date FROM g_article WHERE reid=0 AND id='{$_GET['id']}'")){
		//阅读数+1
		_query("UPDATE g_article SET readcount=readcount+1 WHERE id='{$_GET['id']}'");
		//读取回帖
		global $pagenum, $pagesize;
		page_sta(20, "SELECT id FROM g_article WHERE reid='{$_clean['reid']}'");
		$result = _query("SELECT username,title,content,date,type FROM g_article WHERE reid='{$_clean['reid']}'");
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
<script type="text/javascript" src="js/rcode.js"></script>
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
	<?php 
		while(!!$_row = _fetch_list($result)){ 
			$re_html['username'] = $_row['username'];
			$re_html['title'] = $_row['title'];
			$re_html['content'] = $_row['content'];
			$re_html['type'] = $_row['type'];
			$re_html['date'] = $_row['date'];
			if (!!$row_user = _fetch_query("SELECT g_id,g_username,g_face,g_email FROM g_user WHERE g_username='{$re_html['username']}' LIMIT 1")){
				$row_user = html_spc($row_user);
			}

	 ?>
		<div class="re"><!--回贴部分-->
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
				<?php echo _ubb($re_html['content']); ?>
			</div>
			<div id="read">
				阅读数：（<?php echo $row['readcount']; ?>）
				评论数：（<?php echo $row['commendcount']; ?>）
			</div>
		</div>
		<?php }
		?>
		<!--回帖模块-->
	<?php if(isset($_COOKIE['username'])) {?>
	<form  action="?action=rearticle" method="post">
		<ul>
			<li>发表评论</li>
			<input name="reid" type="hidden" value="<?php echo $row['id']; ?>" />
			<input name="type" type="hidden" value="<?php echo $row['type']; ?>" />
			<li>标题：<input type="text" name="title" class="text" value="<?php echo 'RE:'.$row['title'].''; ?>" placeholder="* 必填2~20位" /></li>
			<li><textarea name="comment" id="" cols="25" rows="10"></textarea></li>
			<li>验 证  码：<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></li>
			<li><input type="submit" value="发表" class="submit" />
				<input type="button" value="返回" class="submit" onclick="javascript:location.href='./index.php'" /></li>
		</ul>
	</form>
	<?php } ?>
</div>

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>