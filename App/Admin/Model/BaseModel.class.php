<?php
namespace Admin\Model;
use Think\Model;

class BaseModel extends Model {
    protected function auto_date_now(){
        $now = time();
        $date_now = date("Y-m-d H:i:s",$now);
        return $date_now;
    }
    protected function getusername() {
        $username = session('user');
        return $username['username'];
    }
    protected function getuid() {
        $uid = session('user');
        return $uid['uid'];
    }
}