window.onload = function(){
	var $faceimg = document.getElementById('faceimg');
	var $rcodeimg = document.getElementById('rcodeimg');
	$faceimg.onclick = function(){
		window.open('face.php', 'face', 'width=400,height=400,top=200,left=200,scrollbars=1');

	}

	$rcodeimg.onclick = function(){
		this.src = 'rcode.php?tm='+Math.random();
	}
}



