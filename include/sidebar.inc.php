<?php 
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
?>
<div id="sidebar">
	<h2>中心导航</h2>
	<dl>
		<dt>帐号管理</dt>
		<dd><a href="member.php">个人信息</a></dd>
		<dd><a href="member_modify.php">修改资料</a></dd>
	</dl>
	<dl>
		<dt>其他管理</dt>
		<dd><a href="member_message.php">消息查询</a></dd>
		<dd><a href="member_friend.php">好友设置</a></dd>
		<dd><a href="member_praise.php">查询点赞</a></dd>
		<dd><a href="#">个人相册</a></dd>
	</dl>
</div>