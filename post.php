<?php 
/*  注册界面*/
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, post);
require  dirname(__FILE__).'/include/common.inc.php';
session_start();
//判断用户状态，登录后才可发帖
if (!isset($_COOKIE['username'])) exit('发帖前必须登录');
if ($_GET['action'] == 'post') {

	ck_code($_POST['rcode'], $_SESSION['rcode']);
	$_clean['username'] = $_COOKIE['username'];
	$_clean['type'] = $_POST['type'];
	$_clean['title'] = ck_post_title(2, 40, $_POST['title']);
	$_clean['content'] = ck_post_content($_POST['content'], 5);
	$_clean = mysql_str($_clean);
	//写入数据库
	_query("INSERT INTO g_article (username, type, title, content, date) VALUES ('{$_clean['username']}', '{$_clean['type']}', '{$_clean['title']}', '{$_clean['content']}', Now())");
	//写入后的判断
	if (_affected() == 1){
		$_clean['id'] = mysql_insert_id();//获取刚刚新增的id值
		_close();
		session_destroy();
		location_href('发布成功', "article.php?id={$_clean['id']}");
	}else{
		_close();
		session_destroy();
		alert_back('发布失败！');
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>计算机协会-发表文章</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/rcode.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="post">
	<h2>发表文章</h2>
	<form method="post" name="post" action="?action=post"><!-- 对提交后页面进行刷新,伪造get方式提交 -->
		<dl>
		<dt>随便说点啥吧</dt>

		<dd>标题：<input type="text" name="title" class="text" placeholder="* 必填2~20位" /></dd>
		<dd>类型：
			<?php 
				foreach (range(1, 10) as $num){
					if ($num == 1) {
						echo '<label for="type'.$num.'"><input type="radio" name="type" id="type'.$num.'" value="'.$num.'" checked="checked" />';
					}else{
						echo '<label for="type'.$num.'"><input type="radio" name="type" id="type'.$num.'" value="'.$num.'" />';						
					}
					
					echo '<img src="images/icon'.$num.'.gif" class="type" alt="类型"></label>';
					if ($num == 5) echo '<br />　 　　';
				}
			 ?>
		</dd>
		<dd id="bq">表情: <a href="javascript:;" >贴图系列1</a>　　　<a href="javascript:;" >贴图系列2</a>　　　<a href="javascript:;" >贴图系列3</a></dd>
		<dd class="img_">
			<?php require ROOT_PATH.'include/ubb.inc.php' ?>
			<textarea name="content" rows="9" ></textarea>
		</dd>

		<dd>验 证  码：<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></dd>
		<dd><input type="submit" value="发表" class="submit" />
			<input type="button" value="返回" class="submit" onclick="javascript:location.href='./index.php'" /></dd>
		</dl>
		
	</form>
	
	
	
	
	
	
</div>






<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>