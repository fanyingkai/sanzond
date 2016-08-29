<?php
/* 根据请求的url判断是否是正式用户，或者是匿名 */
$str = chosedb();
$dbpath = $str.'.php';
return include $dbpath;
