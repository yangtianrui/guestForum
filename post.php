<?php 
/*  注册界面*/
header("Content-Type:text/html;charset=utf-8");
define(IN_CF, true);
define(SCRIPT, post);
require  dirname(__FILE__).'/include/common.inc.php';
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
<title>计算机协会-发表文章</title>
<?php 
require ROOT_PATH.'include/title.inc.php';
?>
<script type="text/javascript" src="js/rcode.js"></script>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php 
require ROOT_PATH."include/header.inc.php";//转换硬路径，提高访问速度
?>
<div id="post">
	<h2>发表文章</h2>
	<form method="post" name="post" action="?action=post"><!-- 对提交后页面进行刷新,伪造get方式提交 -->
		<input type="hidden" name="uniqid" value="<?php echo $_uniq;?>" />
		<dl>
		<dt>随便说点啥吧</dt>

		<dd>标题：<input type="text" name="title" class="text" placeholder="* 必填2~20位" /></dd>
		<dd>类型：
			<?php 
				foreach (range(1, 10) as $num){
					if ($num == 1) {
						echo '<label for="type'.$num.'"><input type="radio" name="type" id="type'.$num.'" value="'.$num.'" checked="checked" />';
					}else{
						echo '<label for="type'.$num.'"><input type="radio" name="type" id="type'.$num.'" value="'.$num.'" />';						
					}
					
					echo '<img src="images/icon'.$num.'.gif" class="type" alt="类型"></label>';
					if ($num == 5) echo '<br />　 　　';
				}
			 ?>
		</dd>
		<dd>贴图: 贴图系列1　　　贴图系列2　　　贴图系列3</dd>
		<dd class="img_">
			<div id="ubb" >
					<img src="images/fontsize.gif" title="字体大小" alt="字体大小" />
					<img src="images/space.gif" title="线条" alt="线条" />
					<img src="images/bold.gif" title="粗体" />
					<img src="images/italic.gif" title="斜体" />
					<img src="images/underline.gif" title="下划线" />
					<img src="images/strikethrough.gif" title="删除线" />
					<img src="images/space.gif" />
					<img src="images/color.gif" title="颜色" />
					<img src="images/url.gif" title="超链接" />
					<img src="images/email.gif" title="邮件" />
					<img src="images/image.gif" title="图片" />
					<img src="images/swf.gif" title="flash" />
					<img src="images/movie.gif" title="影片" />
					<img src="images/space.gif" />
					<img src="images/left.gif" title="左区域" />
					<img src="images/center.gif" title="中区域" />
					<img src="images/right.gif" title="右区域" />
					<img src="images/space.gif" />
					<img src="images/increase.gif" title="扩大输入区" />
					<img src="images/decrease.gif" title="缩小输入区" />
					<img src="images/help.gif" />
			</div>
			<div id="font">
				<strong onclick="font(10)">10px</strong>
				<strong onclick="font(12)">12px</strong>
				<strong onclick="font(14)">14px</strong>
				<strong onclick="font(16)">16px</strong>
				<strong onclick="font(18)">18px</strong>
				<strong onclick="font(20)">20px</strong>
				<strong onclick="font(22)">22px</strong>
				<strong onclick="font(24)">24px</strong>
			</div>
			<div id="color">
				<strong title="黑色" style="background:#000" onclick="showcolor('#000')"></strong>
				<strong title="褐色" style="background:#930" onclick="showcolor('#930')"></strong>
				<strong title="橄榄树" style="background:#330" onclick="showcolor('#330')"></strong>
				<strong title="深绿" style="background:#030" onclick="showcolor('#030')"></strong>
				<strong title="深青" style="background:#036" onclick="showcolor('#036')"></strong>
				<strong title="深蓝" style="background:#000080" onclick="showcolor('#000080')"></strong>
				<strong title="靓蓝" style="background:#339" onclick="showcolor('#339')"></strong>
				<strong title="灰色-80%" style="background:#333" onclick="showcolor('#333')"></strong>
				<strong title="深红" style="background:#800000" onclick="showcolor('#800000')"></strong>
				<strong title="橙红" style="background:#f60" onclick="showcolor('#f60')"></strong>
				<strong title="深黄" style="background:#808000" onclick="showcolor('#000')"></strong>
				<strong title="深绿" style="background:#008000" onclick="showcolor('#808000')"></strong>
				<strong title="绿色" style="background:#008080" onclick="showcolor('#008080')"></strong>
				<strong title="蓝色" style="background:#00f" onclick="showcolor('#00f')"></strong>
				<strong title="蓝灰" style="background:#669" onclick="showcolor('#669')"></strong>
				<strong title="灰色-50%" style="background:#808080" onclick="showcolor('#808080')"></strong>
				<strong title="红色" style="background:#f00" onclick="showcolor('#f00')"></strong>
				<strong title="浅橙" style="background:#f90" onclick="showcolor('#f90')"></strong>
				<strong title="酸橙" style="background:#9c0" onclick="showcolor('#9c0')"></strong>
				<strong title="海绿" style="background:#396" onclick="showcolor('#396')"></strong>
				<strong title="水绿色" style="background:#3cc" onclick="showcolor('#3cc')"></strong>
				<strong title="浅蓝" style="background:#36f" onclick="showcolor('#36f')"></strong>
				<strong title="紫罗兰" style="background:#800080" onclick="showcolor('#800080')"></strong>
				<strong title="灰色-40%" style="background:#999" onclick="showcolor('#999')"></strong>
				<strong title="粉红" style="background:#f0f" onclick="showcolor('#f0f')"></strong>
				<strong title="金色" style="background:#fc0" onclick="showcolor('#fc0')"></strong>
				<strong title="黄色" style="background:#ff0" onclick="showcolor('#ff0')"></strong>
				<strong title="鲜绿" style="background:#0f0" onclick="showcolor('#0f0')"></strong>
				<strong title="青绿" style="background:#0ff" onclick="showcolor('#0ff')"></strong>
				<strong title="天蓝" style="background:#0cf" onclick="showcolor('#0cf')"></strong>
				<strong title="梅红" style="background:#936" onclick="showcolor('#936')"></strong>
				<strong title="灰度-20%" style="background:#c0c0c0" onclick="showcolor('#c0c0c0')"></strong>
				<strong title="玫瑰红" style="background:#f90" onclick="showcolor('#f90')"></strong>
				<strong title="茶色" style="background:#fc9" onclick="showcolor('#fc9')"></strong>
				<strong title="浅黄" style="background:#ff9" onclick="showcolor('#ff9')"></strong>
				<strong title="浅绿" style="background:#cfc" onclick="showcolor('#cfc')"></strong>
				<strong title="浅青绿" style="background:#cff" onclick="showcolor('#cff')"></strong>
				<strong title="浅蓝" style="background:#9cf" onclick="showcolor('#9cf')"></strong>
				<strong title="淡紫" style="background:#c9f" onclick="showcolor('#c9f')"></strong>
				<strong title="白色" style="background:#fff" ></strong>
				<em><input type="text" name="t" /></em>
			</div>
			<textarea name="content" rows="9" ></textarea>
		</dd>

		<dd>验 证  码：<input type="text" name="rcode" class="text rcode" /><img src="rcode.php" id="rcodeimg"></dd>
		<dd><input type="submit" value="发表" class="submit" />
			<input type="button" value="返回" class="submit" onclick="javascript:location.href='./index.php'" /></dd>
		</dl>
		
	</form>
	
	
	
	
	
	
</div>






<?php 
require ROOT_PATH."include/footer.inc.php";
?>
</body>
</html>