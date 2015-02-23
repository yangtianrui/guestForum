<?php
/* 调用header界面 */

	if(!defined('IN_CF')) {//没有授权，直接退出
		exit("Access Defined");
	}
	define(STA_TIME, use_time());
?>
<div id="header">
	<h1>计算机协会</h1>
	<ul>
	<li><a href="index.php">首页</a></li>

	<?php 
		if (isset($_COOKIE['username'])){
			echo "<li><a href='member.php' style='font-weight:bold;'>{$_COOKIE['username']}的个人中心</a></li>";
		}else{
			echo '<li><a href="zhuce.php">注册</a></li> <li><a href="login.php">登录</a></li>';
		}
	?>
	<li><a href="blog.php">会员</a></li>
	<li>风格 </li>
	<li>管理</li>
	<?php 
		if (isset($_COOKIE['username'])){
			echo '<li><a href="logout.php">退出</a></li>';
		}
	?>
	
	</ul>
</div>




