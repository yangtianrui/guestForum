<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>计算机协会</title>
</head>

<?php 
define(IN_CF, true);//定义 一个常量，防止非法调用
define(SCRIPT, index);//这个常量用来证明本页
require  dirname(__FILE__).'/include/common.inc.php';
require ROOT_PATH.'include/title.inc.php';
?>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>




<div id="list">
	<h2>帖子列表</h2>
</div>
<div id="user">
	<h2>新进会员</h2>
</div>
<div id="pics">
	<h2>最新图片</h2>
</div>





<?php 
require ROOT_PATH."include/footer.inc.php";

?>






</body>
</html>