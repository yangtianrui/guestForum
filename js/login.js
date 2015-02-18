window.onload = function() {
	rcode();
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
			alert('密码错误！');
			$fm.password.value = '';
			$fm.password.focus();
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