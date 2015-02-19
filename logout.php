<?php 
define(IN_CF, true);
session_start();
require  dirname(__FILE__).'/include/common.inc.php';


_unsetcookie();//删除cookie就意味着用户的登录状态消失




?>