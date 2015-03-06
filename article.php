<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'article');
require  dirname(__FILE__).'/include/common.inc.php';

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
			<dd class="user">#$%</dd>
			<dt><img src="face/m01.gif" alt="admin" /></dt>
			<dd class="message"><a href="javascript:void(0);" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:void(0);" name="friend" title="<?php echo $_html['id'];?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:void(0);" name="praise" title="<?php echo $_html['id'];?>">给他点赞</a></dd>
			<dd class="email"><a href="mailto:<?php echo $_html['email'];?>">邮箱：#$%</a></dd>
		</dl>
		<div id="content">
			<div class="user">
				<span>1#</span>文章来自 ：| admin 发布于 ***********
			</div>
			<h3>主题： ******* ########<img src="images/icon1.gif" alt=""></h3>
			<div class="detail">
				sadfsadfasdfsadfsdffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
			</div><!-- / -->
		</div>
	</div>
	<p class="line"></p>
</div>

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>