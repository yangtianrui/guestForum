<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'blog');
require  dirname(__FILE__).'/include/common.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>博友列表</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>

</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>

<div id="blog">
	<h2>博友列表</h2>
	<?php for($i=10;$i<30;$i++){ ?>
	<dl>
		<dd class="user">admin</dd>
		<dt><img src="face/m<?php echo $i;?>.gif" alt="admin" /></dt>
		<dd class="message">发消息</dd>
		<dd class="friend">加为好友</dd>
		<dd class="guest">写留言</dd>
		<dd class="flower">给他送花</dd>
	</dl>
	<?php }?>
</div>





<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>