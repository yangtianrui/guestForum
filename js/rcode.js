function rcode() {
	var $rcodeimg = document.getElementById('rcodeimg');
	$rcodeimg.onclick = function(){
		this.src = 'rcode.php?tm='+Math.random();
	}
	
}

/**
 * 从中间弹出窗口
 * @param  {[type]} url    [description]
 * @param  {[type]} name   [description]
 * @param  {[type]} width  [description]
 * @param  {[type]} height [description]
 * @return {[type]}        [description]
 */
function centerWindow(url, name, width, height) {
    var top = (screen.height - height)/2;
    var left = (screen.width - width)/2;
    window.open(url, name, 'width='+width+',height='+height+',top='+top+',left='+left);
}