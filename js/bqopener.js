window.onload = function(){
	var $img = document.getElementsByTagName('img')
	for (var i=0;i<$img.length;i++) {
		$img[i].onclick = function(){
			opener.document.getElementsByTagName('form')[0].content.value += '[img]'+this.alt+'[/img]';
		}
		$img[i].addEventListener("click", function(){
			window.close();
		});
	};
};


