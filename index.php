<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>计算机协会</title>
<script type="text/javascript" src="js/blog.js"></script>
</head>

<?php 
define(IN_CF, true);//定义 一个常量，防止非法调用
define(SCRIPT, index);//这个常量用来证明本页
require  dirname(__FILE__).'/include/common.inc.php';
require ROOT_PATH.'include/title.inc.php';
$_html = html_spc(get_xml('new.xml'));//获取xml文件
//获取帖子列表 
global $pagenum, $pagesize;
page_sta(10, 'SELECT id FROM g_article');
$result = mysql_query("SELECT id,username,type,title,content,readcount,commendcount FROM g_article WHERE reid=0 ORDER by date DESC LIMIT $pagenum,$pagesize");

?>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>




<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" title="帖子列表" class="post">发表帖子</a>
	<ul class="article">
		<?php while(!!$_row = _fetch_list($result)){ 
			echo '<li class="icon'.$_row['type'].'"><em>阅读数（'.$_row['readcount'].'）评论数（'.fix_content($_row['commendcount']).'）</em><a href="article.php?id='.$_row['id'].'">'.$_row['title'].'</a></li>';
 		}
 		mysql_free_result($result);
 		?>
	</ul>
	<?php paging(); ?>
</div>
<div id="user">
	<h2>新进会员</h2>
	<dl>
		<dd class="user"><?php echo $_html['username']?></dd>
		<dt><img src="<?php echo $_html['face']?>" alt="admin" /></dt>
		<dd class="message"><a href="javascript:void(0);" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:void(0);" name="friend" title="<?php echo $_html['id'];?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:void(0);" name="praise" title="<?php echo $_html['id'];?>">给他点赞</a></dd>
		<dd class="email"><a href="mailto:<?php echo $_html['email'];?>">邮箱：<?php echo $_html['email'];?></a></dd>
	</dl>
</div>
<div id="pics">
	<h2>最新图片</h2>
</div>





<?php 
require ROOT_PATH."include/footer.inc.php";

?>






</body>
</html>