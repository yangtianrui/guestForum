function rcode() {
	var $rcodeimg = document.getElementById('rcodeimg');
	$rcodeimg.onclick = function(){
		this.src = 'rcode.php?tm='+Math.random();
	}
	
}