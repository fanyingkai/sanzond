<?php
namespace Home\Controller;
use Think\Controller;

class HomeController extends Controller{
    
    public function _initialize() {
        if(!session('?userid')) {
            $this->redirect('Auth/login');
        }
        $config = D('Config')->getconfig();
        $this->assign('config',$config);
    }
    
    public function ajaxReturn($status,$info,$data) {
        $json['status'] = $status;
        $json['info'] = $info;
        $json['data'] = $data;
        parent::ajaxReturn($json);
    }
    
    public function getuserid() {
        return base64_decode(session('userid'));
    }
}