window.onload = function(){
	//头像选择
	var $faceimg = document.getElementById('faceimg');
	var $rcodeimg = document.getElementById('rcodeimg');
	$faceimg.onclick = function(){
		window.open('face.php', 'face', 'width=400,height=400,top=200,left=200,scrollbars=1');

	}

	$rcodeimg.onclick = function(){
		this.src = 'rcode.php?tm='+Math.random();
	}
	//表单验证
	var $fm = document.getElementsByTagName('form')[0];
	$fm.onsubmit = function(){
		if($fm.username.value.length<2 || $fm.username.length>20) {
			alert('用户名长度错误！');
			$fm.username.value = '';
			$fm.username.focus();
			return false;//组织默认提交行为
		}		
		if(/[<>\'\"\ \　]/.test($fm.username.value)){
			alert('用户名不能包含特殊字符！');
			$fm.username.value = '';
			$fm.username.focus();
			return false;
		}
		if($fm.password.value.length<6) {
			alert('密码不得小于6位！');
			$fm.password.value = '';
			$fm.password.focus();
			return false;
		}
		if($fm.password.value != $fm.notpassword.value) {
			alert('两次输入不相等');
			$fm.notpassword.value = '';
			$fm.notpassword.focus();
			return false;
		}
		if($fm.question.value.length<4) {
			alert('密码提示不得小于4位！');
			$fm.question.value = '';
			$fm.question.focus();
			return false;
		}
		
		if($fm.answer.value.length<4) {
			alert('密码回答不得小于4位！');
			$fm.answer.value = '';
			$fm.answer.focus();
			return false;
		}
		if($fm.question.value == $fm.answer.value) {
			alert('问题答案不能相等');
			$fm.answer.value = '';
			$fm.answer.focus();
			return false;
		}
		if(!/^([\w\-\.]+)(@[\w\-\.]+)\.([\w]{2,4})$/.test($fm.email.value)){
			alert('邮箱格式不正确！');
			$fm.email.value = '';
			$fm.email.focus();
			return false;
		}
		if($fm.rcode.value.length != 4){
			alert('验证码错误！');
			$fm.rcode.value = '';
			$fm.rcode.focus();
			return false;
		}
		return true;
	}
	
	
	
	
	

	
}



