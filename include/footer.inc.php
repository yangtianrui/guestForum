<?php 
/* 调用footer */
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
?>


<div id="footer">

<p>版权所有，翻版必究.本页面耗时约<?php echo round(use_time() - STA_TIME, 4);?>秒</p>
</div>