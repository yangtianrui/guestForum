<?php 
session_start();
 ?>
<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'blog');
require  dirname(__FILE__).'/include/common.inc.php';
global $pagenum, $pagesize;
page_sta(20, 'SELECT g_username FROM g_user');
$result = mysql_query("SELECT g_id,g_username,g_face,g_sex FROM g_user ORDER by g_reg_time DESC LIMIT $pagenum,$pagesize");

?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>博友列表</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>

<div id="blog">
	<h2>会员列表</h2>
	<?php 
	while(!!$_row = _fetch_list($result)){ 
		$_row = html_spc($_row);
	//使用字符串作为下标
	?>
	<dl>
		<dd class="user"><?php echo $_row['g_username']; ?></dd>
		<dt><img src="<?php echo $_row['g_face'];?>" alt="admin" /></dt>
		<dd class="message"><a href="javascript:void(0);" name="message" title="<?php echo $_row['g_id'];?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:void(0);" name="friend" title="<?php echo $_row['g_id'];?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:void(0);" name="praise" title="<?php echo $_row['g_id'];?>">给他点赞</a></dd>
	</dl>
<?php }?>
	<?php 
		mysql_free_result($result);//销毁结果集
		paging(1);//调用分页函数
	?>
</div>

<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>