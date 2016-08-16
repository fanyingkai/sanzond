<?php
namespace Home\Logic;
use Think\Model;

class BaseLogic extends Model{

    public function hot($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_hot'=>1,'is_active'=>1);
        } else {
            $where = array('is_hot'=>1,'is_active'=>1,'secid'=>$secid);
        }
        $hotlist = $this->order('date_joined desc')->where($where)->limit($limit)->select();
        return $hotlist;
    }
    
    public function newest($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_active'=>1);
        } else {
            $where = array('is_active'=>1,'secid'=>$secid);
        }
        $newctm = $this->where($where)->order("date_joined desc")->limit($limit)->select();
        return $newctm;
    }
    
    public function recommend($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_active'=>1,'is_recommend'=>1);
        } else {
            $where = array('is_active'=>1,'is_recommend'=>1,'secid'=>$secid);
        }
        $recommendctm = $this->where($where)->order('date_joined desc')->limit($limit)->select();
        return $recommendctm;
    }
    public function getuserid() {
        return base64_decode(session('userid'));
    }    
}
