
window.onload = function() {
	rcode();
	var $fm = document.getElementsByTagName('form')[0];
	$fm.onsubmit = function() {
		if($fm.password.value != ''){
			if($fm.password.value.length<6) {
				alert('密码不得小于6位！');
				$fm.password.value = '';
				$fm.password.focus();
				return false;
			}
	
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

