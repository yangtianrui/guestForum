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
	<li><a href="zhuce.php">注册</a></li>
	<li><a href="login.php">登录</a></li>
	<li>个人中心</li>
	<li>风格 </li>
	<li>管理</li>
	<li>退出</li>
	</ul>
</div>




