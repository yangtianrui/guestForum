<?php 
/*提供表情选择界面*/
define(IN_CF, true);
define(SCRIPT, bq1);
require  dirname(__FILE__).'/include/common.inc.php';
//初始话页面，并且判断传入参数
if( isset($_GET['num']) && isset($_GET['path']) ){
    if (!is_dir(ROOT_PATH.$_GET['path'])) alert_back('非法操作，不存在该目录！');
}else{
    alert_back('非法操作，请返回');
}
?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>表情选择</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/bqopener.js"></script>
</head>
<body>
<div id="face">
	<h3>表情选择</h3>
	<dl>
		<?php foreach(range(1, $_GET['num']) as $_num){?>
		<dd><img src="<?php echo $_GET['path'].$_num ?>.gif" alt="<?php echo $_GET['path'].$_num ?>.gif" ></dd>
		<?php }?>
	</dl>
</div>
</body>
</html>







