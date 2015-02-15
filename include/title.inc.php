<?php 
/*引入相关链接文件*/
if(!defined('IN_CF')) {//没有授权，直接退出
	exit("Access Defined");
}
//防止非html页面调用
if (!defined('SCRIPT')){
	exit('Script Error!');
}
?>
<link rel="stylesheet" type="text/css" href="style/1/basic.css">
<link rel="stylesheet" type="text/css" href="style/1/<?php echo SCRIPT;?>.css">
<link rel="shortcut icon" href="images/Favicon.ico">
