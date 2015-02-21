<?php 
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, 'blog');
require  dirname(__FILE__).'/include/common.inc.php';
if (isset($_GET['page'])){
	$pagenow = $_GET['page'];
	//如果page参数不存在，或者不合法，使初始页面的参数为1 
	if (empty($_GET['page']) || $_GET['page'] < 0 || !is_numeric($_GET['page'])){
		$pagenow = 1;
	}else{
		$pagenow = intval($_GET['page']);//对浮点数取整
	}
}else{
	$pagenow = 1;
}

$pagesize = 20;

$page_sum = mysql_num_rows(_query("SELECT g_username FROM g_user"));//返回所有搜索结果的字段数
if ($page_sum == 0){
	$page_abs = 1;//如果数据库中没有数据，默认显示第一页
}else{
	$page_abs = ceil($page_sum/$pagesize);
}

if ($pagenow > $page_abs){
	$pagenow = $page_abs;
}
$pagenum = ($pagenow-1)*$pagesize;
$result = mysql_query("SELECT g_username,g_face,g_sex FROM g_user ORDER by g_reg_time DESC LIMIT $pagenum,$pagesize");

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
	<?php while(!!$_row = _fetch_list($result)){ //使用字符串作为下标?>
	<dl>
		<dd class="user"><?php echo $_row['g_username']; ?></dd>
		<dt><img src="<?php echo $_row['g_face'];?>" alt="admin" /></dt>
		<dd class="message">发消息</dd>
		<dd class="friend">加为好友</dd>
		<dd class="guest">写留言</dd>
		<dd class="flower">给他送花</dd>
	</dl>
<?php }?>
	<div id="pagenum">
		<ul>
			<?php for($i=1;$i<$page_abs+1;$i++){
				if ($pagenow == $i){
					echo '<li><a href="blog.php?page='.$i.'" class="selected">'.$i.'</a></li>';
				}else{
					echo '<li><a href="blog.php?page='.$i.'">'.$i.'</a></li>';
				}

			}?>
		</ul>
	</div>
	<div id="page_text">
		<ul>
			<li><?php echo $pagenow; ?>/<?php echo $page_abs; ?>页 |</li>
			<li>共有<strong><?php echo $page_sum; ?></strong>个会员 |</li>
			<?php if ($pagenow == 1) {
						echo '<li>首页 |</li>';
						echo '<li>上一页 |</li>';
				  } else {//$_SERVER['SCRIPT_NAME']是php环境变量，会返回当前页面的名称,也可使用本页面自定义的常量SCRIPT
				  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page=1">首页</a> |</li>';
				  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.($pagenow-1).'">上一页</a> |</li>';
				  }
				 if ($pagenow == $page_abs) {
						echo '<li>下一页 |</li>';
						echo '<li>尾页 |</li>';
						
				  } else {
				  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.($pagenow+1).'">下一页</a> |</li>';
				  		echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.$page_abs.'">尾页</a> |</li>';
				  		
				  } 
			?>
		</ul>
	</div>
</div>





<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>