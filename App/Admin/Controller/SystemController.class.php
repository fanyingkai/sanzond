<?php
namespace Admin\Controller;

class SystemController extends AdminController{
    public function index() {
        $config = D('Config');
        if(IS_POST) {
            $type = $_POST['type'];
            $keyword = $_POST['keyword'];
            if($type=='0') {
                $where = "alias like '%{$keyword}%' or name like '%{$keyword}%' or value like '%{$keyword}%'";
                $configlist = $config->where($where)->select();
            } else {
                $where = "alias like '%{$keyword}%' or name like '%{$keyword}%' or value like '%{$keyword}%'";
                $configlist = $config->where(array('type'=>$type))->where($where)->select();
            }
            $this->assign('type',$type);
        } else {
            $configlist = $config->select();
        }
        $typelist = $config->distinct(true)->field('type')->select();
        $this->assign('typelist',$typelist);
        $this->assign('configlist',$configlist);
        $this->display();
    }
    
    public function editconfig($id) {
        $confM = D('Config');
        $config = $confM->where(array('id'=>$id))->find();
        $typelist = $confM->distinct(true)->field('type')->select();
        $this->assign('typelist',$typelist);
        $this->assign('config',$config);
        $this->display();
    }
    
    public function delconfig() {
        $id = $_POST['id'];
        $result = D('Config')->where(array('id'=>$id))->delete();
        if($result) {
            $json['status'] = '1';
            $this->ajaxReturn($json);
        } else {
            $json['status']='0';
            $json['info'] = '删除失败！请重新尝试';
            $this->ajaxReturn($json);
        }
        
    }
}