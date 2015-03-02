<?php 
/*  注册界面*/
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, zhuce);
require  dirname(__FILE__).'/include/common.inc.php';
login_state();
session_start();

?>
<?php 
if ($_GET['action'] == 'zhuce.php') {
	ck_code($_POST['rcode'], $_SESSION['rcode']);
	include ROOT_PATH.'include/zhuce.func.php';//include一般在表达式中引入数据
	$_clean = array();//存放过滤过的表单数据
	$_clean['uniqid'] = ck_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
	$_clean['active'] = sha_uniq();//，再创建一个唯一标识符，对刚注册的用户进行激活处理。
	$_clean['username'] = ck_username($_POST['username'], 2, 20);
	$_clean['password'] = ck_passwd($_POST['password'], $_POST['notpassword']);
	$_clean['question'] = ck_ques($_POST['question'], 2, 20);
	$_clean['answer'] = ck_ans($_POST['answer'], $_POST['question'], 2, 20);
	$_clean['sex'] = ck_sex_face($_POST['sex']);
	$_clean['face'] = ck_sex_face($_POST['face']);
	$_clean['email'] = ck_email($_POST['email'], 2, 40);
	//判断用户名是否重复
	if (_fetch_query("SELECT g_username FROM g_user WHERE g_username='{$_clean['username']}' LIMIT 1")) {
		alert_back('此用户名已存在！');
	}
	//" "里面直接放变量是可以的，但放数组应该使用{}将内容包起来  如：{$_clean['username]}
	_query("INSERT INTO g_user (g_uniqid, g_active, g_username, g_password, g_question, g_answer, g_email,	g_sex, g_face, g_reg_time,	g_last, g_ip) VALUES ('{$_clean['uniqid']}','{$_clean['active']}','{$_clean['username']}','{$_clean['password']}','{$_clean['question']}','{$_clean['answer']}','{$_clean['email']}','{$_clean['sex']}','{$_clean['face']}',NOW(),NOW(),'{$_SERVER["REMOTE_ADDR"]}')") or die('sql执行失败'.mysql_error());
	if (_affected() == 1){
		$_clean['id'] = mysql_insert_id();//获取刚刚新增的id值
		set_xml('new.xml', $_clean);//注册完成后新建一个xml保存新用户信息 
		_close();
		session_destroy();
		location_href('注册成功', "./active.php?active=$_clean[active]");
	}else{
		_close();
		session_destroy();
		location_href('未知错误！请重试', './zhuce.php');
	}



}else {//没有提交的话生成一个唯一标识符
	$_SESSION['uniqid'] = $_uniq = sha_uniq();//使用唯一标识符防止伪造表单提交
}


 ?>
<!DOCTYPE html>
<html>
<head>
<META charset="utf-8">
<title>计算机协会-用户注册</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/face.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="zhuce">
	<h2>会员注册</h2>
	<form method="post" name="zhuce" action="?action=zhuce.php"><!-- 对提交后页面进行刷新,伪造get方式提交 -->
		<input type="hidden" name="uniqid" value="<?php echo $_uniq;?>" />
		<dl>
		<dt>请认真填写以下信息，*项必填。</dt>
		<dd>用 户    名：<input type="text" name="username" class="text" placeholder="*2~20位数字或字母汉字" /></dd>
		<dd>密　　码：<input type="password" name="password" class="text" placeholder="*至少六位" /></dd>
		<dd>确认密码：<input type="password" name="notpassword" class="text" placeholder="*" /></dd>
		<dd>提示问题：<input type="text" name="question" class="text" placeholder="*至少4位" /></dd>
		<dd>提示答案：<input type="text" name="answer" class="text" placeholder="*至少4位" /></dd>
		<dd>性　　别：<input type="radio" name="sex" checked="checked"value=" 男" />男
					<input type="radio" name="sex" value=" 女" />女</dd>
		<dd><input type="hidden" name="face" value="face/m01.gif" /><img src="face/m01.gif" alt="头像选择" class="face" id="faceimg"></dd>
		<dd>电子邮件：<input type="text" name="email" class="text" placeholder="*" /></dd>
		<dd>验 证  码：<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></dd>
		<dd><input type="submit" value="注册" class="submit" />
			<input type="button" value="返回" class="submit" onclick="javascript:location.href='./index.php'" /></dd>
		
		</dl>
		
	</form>
	
	
	
	
	
	
</div>






<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>