<?php 
/*提供头像选择界面*/
define(IN_CF, true);
define(SCRIPT, face);
require  dirname(__FILE__).'/include/common.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>头像选择</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>
<div id="face">
	<h3>选择头像</h3>
	<dl>
		<?php foreach(range(1, 9) as $num){?>
		<dd><img src="face/m0<?php echo $num;?>.gif" alt="face/m0<?php echo $num;?>.gif" ></dd>
		<?php }?>
		<?php foreach(range(10, 64) as $num){?>
		<dd><img src="face/m<?php echo $num;?>.gif" alt="face/m<?php echo $num;?>.gif"></dd>
		<?php }?>
	</dl>
</div>
</body>
</html>







