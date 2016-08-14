<?php
namespace Admin\Controller;

use Think\Page;
class UserController extends AdminController {
    public function index() {
        $m = D('User');
        $utm = M('auth_group');
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
        $gm = M('auth_group');
        $grouplist = $gm->select();
        $this->assign('grouplist',$grouplist);
        $this->display();
    }
    
    public function editgroup($id) {
        $gm = M('auth_group');
        $ginfo = $gm->where(array('id'=>$id))->find();
        $rule = M('auth_rule')->where(array('status'=>'1'))->order('title')->select();
        $this->assign('rule',$rule);
        $this->assign('ginfo',$ginfo);
        $this->display();
    }
    
    public function savegroup() {
        $id = $_POST['id'];
        $data['title'] = $_POST['title'];
        $data['status']= $_POST['status'];
        $rule = $_POST['rule'];
        $rules="";
        foreach($rule as $k=>$v) {
            $rules .= $v.",";
        }
        $data['id']=$id;
        $data['rules']=$rules;
        $grule = M('auth_group');
        $result = $grule->save($data);
        if($result) {
            $this->success('保存成功！');
        } else {
            $this->error('保存失败！');
        }
    }
    
    public function adduser() {
        $gm = M('auth_group');
        $grouplist = $gm->where(array('status'=>'1'))->select();
        $this->assign('grouplist',$grouplist);
        $this->display();
    }
    
    public function edituser($id) {
        $gm = M('auth_group');
        $grouplist = $gm->select();
        $this->assign('grouplist',$grouplist);
        $user = D('User');
        $userinfo = $user->where(array('id'=>$id))->find();
        $this->assign('userinfo',$userinfo);
        $this->display();
    }
    
    public function rulelist() {
        $model = M('auth_rule');
        $count = $model->where('1=1')->count();
        $page = new Page($count,15);
        $show = $page->show();
        $rulelist = $model->order('title')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('rulelist',$rulelist);
        $this->assign('page',$show);
        $this->display();    
    }
    
    public function editrule($id) {
        $model = M('auth_rule');
        $rule = $model->where(array('id'=>$id))->find();
        $this->assign('rule',$rule);
        $this->display();
    }
}