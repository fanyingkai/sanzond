<?php
/*
 * 后台记录日志函数
 */
function recordlog($event,$eventtype,$remark="") {
    $uid = session('user')['uid'];
    $user = M('user')->field('username')->where(array('id'=>$uid))->find();
    $username = $user['username'];
    $data = array(
        'userid'   => $uid,
        'eventtype'=>$eventtype,
        'event' => $event,
        'remark'=>$remark,
        'date_joined'=>time(),
        'client_ip'=>get_client_ip(),
    );
    M('log')->add($data);
}