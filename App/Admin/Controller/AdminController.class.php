<?php
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller {
    public function _initialize() {
        if(!session('?user')){
            $this->error('您未登录！',U('Public/loginx'),1);
        }
        $ctm = M('Content')->field('name,logicname')->where(array('is_active'=>'1'))->select();
        $this->assign('ctmbase',$ctm);
    }
    /* 
     * 对模型CUD操作进行代理，此代理返回操作后相关的信息 ,所有模型均需实现此代理命名规范
     */
    public function cud_proxy($model,$layer='',$action='') {
        //验证用户是否有该操作权限
        //$this->auth_proxy($model, $action);
        //执行用户操作
        $m = D($model,$layer);
        if($action=="D") {
            $status = $m->delete((int)$_REQUEST['id']);
        } else {
            $vo = $m->create($_REQUEST);
            if($vo){
                if(empty($vo['id'])){
                    $id = $m->add($vo);
                    $status = $id?1:0;
                }else{
                    $status = $m->save($vo);
                }
            }
        }
        if($status) {
            $this->success(lang('action_success'));
            recordlog($model.$layer.'/'.$action,'CUD代理操作');
        } else {
            recordlog($model.$layer.'/'.$action,'CUD代理操作','失败'.$m->getError());
            $this->error($m->getError());
        }
    }
    
    public function auth_proxy($model,$action) {
        //$auth = new Auth();
		//此方法需要重写
    }
}