<?php
namespace Admin\Controller;
use Think\Auth;

class TrashController extends AdminController{
    
    public function index() {
        $ctmlist = D('Content')->field('id,name,logicname')->select();
        $ctmmodel = array();
        $trash = array();
        foreach($ctmlist as $k=>$v) {
            $ctmmodel[]=$v['logicname'];
        }
        $i=0;
        foreach($ctmmodel as $k=>$v){
            $list = D($v,'Logic')->trash();
            foreach($list as $k=>$val) {
                $trash[$i]['ctmname'] = $v;
                $trash[$i]['id'] = $val['id'];
                $trash[$i]['name']=$val['name'];
                $trash[$i]['updater']=$val['updater'];
                $trash[$i]['date_update']=$val['date_update'];
                $i++;
            }
        }
        $this->assign('trash',$trash);
        $this->assign('content',$ctmlist);
        $this->display();
    }
    
    public function delctm() {
        $logic = I('logic','');
        //缺少权限验证
        $model = D($logic,'Logic');
        $id = I('id','');
        $result = $model->where(array('id'=>$id))->setField('is_active','3');
        if($result) {
            recordlog('删除'.$logic.$id,'回收站');
            $json['status'] = 1;
        } else {
            $json['status'] = 0;
            $json['info'] = $model->getError();
        }
        $this->ajaxReturn($json);
    }
    
    public function revert() {
        $id = $_POST['id'];
        $logic = $_POST['ctmname'];
        $model = D($logic,'Logic');
        $result= $model->where(array('id'=>$id,'is_active'=>'3'))->setField('is_active','2');
        if($result) {
            recordlog('还原'.$logic.' ID为'.$id,'回收站');
            $json['status'] = 1;
        } else {
            $json['status'] = 0;
            $json['info'] = $model->getError();
        }
        $this->ajaxReturn($json);
    }
    
    public function destroy() {
        $id = $_POST['id'];
        $logic = $_POST['ctmname'];
        $model = D($logic,'Logic');
        $result = $model->where(array('id'=>$id,'is_active'=>'3'))->delete();
        if($result) {
            recordlog('彻底删除'.$logic.' ID为'.$id,'回收站');
            $json['status']=1;
        } else {
            $json['status']=0;
            $json['info'] = $model->getError();
        }
        $this->ajaxReturn($json);
    }
    
}