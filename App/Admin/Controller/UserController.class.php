<?php
namespace Admin\Controller;

use Think\Page;
class UserController extends AdminController {
    public function index() {
        $m = D('User');
        $utm = M('user_group');
        if(IS_POST) {
            $type = $_POST['type'];
            $keyword = $_POST['keyword'];
            if($type=='0') {
                $where = "username like '%{$keyword}%' or phone like '%{$keyword}%' or email like '%{$keyword}%'";
                $userlist = $m->where($where)->select();
            } else {
                $where = "username like '%{$keyword}%' or phone like '%{$keyword}%' or email like '%{$keyword}%'";
                $userlist = $m->where(array('gid'=>$type))->where($where)->select();
            }
            $this->assign('type',$type);
        } else {
            $userlist = $m->select();
        }
        $typelist = $utm->select();
        $this->assign('typelist',$typelist);
        $this->assign('userlist',$userlist);
        $this->display();
    }
    
    public function grouplist() {
        $gm = M('user_group');
        $grouplist = $gm->select();
        $this->assign('grouplist',$grouplist);
        $this->display();
    }
    
    public function editgroup($id) {
        $gm = M('user_group');
        $ginfo = $gm->where(array('id'=>$id))->find();
        $this->assign('rule',$rule);
        $this->assign('ginfo',$ginfo);
        $this->display();
    }
    
    public function savegroup() {
        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['is_active']= $_POST['is_active'];
        $data['id']=$id;
        $grule = M('user_group');
        $result = $grule->save($data);
        if($result) {
            $this->success('保存成功！');
        } else {
            $this->error('保存失败！');
        }
    }
    
    public function adduser() {
        $gm = M('user_group');
        $grouplist = $gm->where(array('status'=>'1'))->select();
        $this->assign('grouplist',$grouplist);
        $this->display();
    }
    
    public function edituser($id) {
        $gm = M('user_group');
        $grouplist = $gm->select();
        $this->assign('grouplist',$grouplist);
        $user = D('User');
        $userinfo = $user->where(array('id'=>$id))->find();
        $this->assign('userinfo',$userinfo);
        $this->display();
    }
}