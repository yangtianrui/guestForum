window.onload = function() {
    rcode();
    var $ubb = document.getElementById('ubb');
    var $ubb_img = $ubb.getElementsByTagName('img');
    var $fm = document.getElementsByTagName('form')[0];
    $ubb_img[2].onclick = function() {
        in_content('[b][/b]');
    }
    $ubb_img[3].onclick = function() {
        in_content('[i][/i]');
    }
    $ubb_img[4].onclick = function() {
        in_content('[u][/u]');
    }
    $ubb_img[5].onclick = function() {
        in_content('[s][/s]');
    }
    //弹出对话框获取用户URL
    $ubb_img[8].onclick = function() {
        var $url = prompt('请输入网址', 'http://');//弹出文本框 参数1：文本框内容   参数2：文本框默认值
        if (!/^https?:\/\/[\w]{1,9}\.[\w]{1,9}\.[\w]{2,4}/.test($url)) {
            alert('提交的网址不合法！');
            $url = null;
        }
        if ($url) in_content('[url]'+$url+'[/url]');
    }
    $ubb_img[9].onclick = function() {
        var $email = prompt('请输入电子邮箱地址');//弹出文本框 参数1：文本框内容   参数2：文本框默认值
        if (!/^([\w\-\.]+)(@[\w\-\.]+)\.([\w]{2,4})$/.test($email)) {
            alert('提交的邮箱地址不合法！');
            $email = null;
        }
        if ($email) in_content('[email]'+$email+'[/email]');
    }
    $ubb_img[10].onclick = function() {
        var $in_img = prompt('请输入图片地址', 'http://');//弹出文本框 参数1：文本框内容   参数2：文本框默认值
        if (!/^https?:\/\/[\w]{1,9}\.[\w]{1,9}\.[\w]{2,4}/.test($in_img)) {
            alert('提交的图片地址不合法！');
            $in_img = null;
        }
        if ($in_img) in_content('[img]'+$in_img+'[/img]');
    }
    $ubb_img[11].onclick = function() {
        var $flash = prompt('请输入FLASH地址', 'http://');//弹出文本框 参数1：文本框内容   参数2：文本框默认值
        if (!/^https?:\/\/[\w]{1,9}\.[\w]{1,9}\.[\w]{2,4}/.test($flash)) {
            alert('提交的链接不合法！');
            $flash = null;
        }
        if ($flash) in_content('[flash]'+$flash+'[/flash]');
    }
    //对文本框的大小进行控制
    $ubb_img[18].onclick = function() {
        if ($fm.content.rows < 15) {
            $fm.content.rows += 2;
        }
    }
    $ubb_img[19].onclick = function() {
        if ($fm.content.rows > 6) {
            $fm.content.rows -= 2;
        }
    }
/**
 * 向文本框中添加指定的字符串,并且累计
 * @param  {[type]} $str [description]
 * @return {[type]}      [description]
 */
    function in_content($str) {
        $fm.content.value += $str;
    }
}
