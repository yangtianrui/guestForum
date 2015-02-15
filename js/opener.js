window.onload = function(){
	var $img = document.getElementsByTagName('img')
	for (var i=0;i<$img.length;i++) {
		$img[i].onclick = function(){
			var $faceimg = opener.document.getElementById('faceimg');// 获取父窗口的节点元素
			$faceimg.src = this.alt;//使用src的属性来赋值
			opener.document.zhuce.face.value = this.alt;//对隐藏的文本框赋值,src是硬路径，应此需要用alt转换
		}
		$img[i].addEventListener("click", function(){
			window.close();
		});
	};
};


