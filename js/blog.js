window.onload = function() {
	var $msg = document.getElementsByName('message');
	for (var i = 0; i < $msg.length; i++) {
		$msg[i].onclick = function() {
			centerWindow('message.php?id='+this.title, 'message', '400', '400');
		}
	};
}



//弹窗函数
function centerWindow(url, name, width, height) {
	var top = (screen.height - height)/2;
	var left = (screen.width - width)/2;
	window.open(url, name, 'width='+width+',height='+height+',top='+top+',left='+left);
}
