<?php
namespace Home\Controller;
use Think\Controller;

class HomeController extends Controller{
    
    public function _initialize() {
        $sectionsm = D('sections');
        $sections = $sectionsm->sectionstree();
        $config = D('Config')->getconfig();
        $this->assign('sections',$sections);
        $this->assign('config',$config);
    }
    
    public function ajaxReturn($status,$info,$data) {
        $json['status'] = $status;
        $json['info'] = $info;
        $json['data'] = $data;
        parent::ajaxReturn($json);
    }
    
}