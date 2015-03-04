window.onload = function() {
	rcode();
	var $fm = document.getElementsByTagName('form')[0];
	$val = $fm.content.value;
	$fm.content.onfocus = function() {
		if (this.value == '说点什么吧。。。') {
			this.value = '';
		}
	}
	$fm.content.onblur = function() {
		if (this.value == '') {
			this.value = $val;
		};
		
	}
	$fm.onsubmit = function() {
		if($fm.rcode.value.length != 4){
			alert('验证码错误！');
			$fm.rcode.value = '';
			$fm.rcode.focus();
			return false;
		}
		if($fm.content.value.length<2) {
			alert('消息内容至少2位！');
			$fm.content.value = '';
			$fm.content.focus();
			return false;
		}
		return true;
	}
}