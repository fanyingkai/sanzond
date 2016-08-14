<?php
namespace Home\Logic;

class ArticleLogic extends BaseLogic{
    public function hot($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_hot'=>1,'is_active'=>1);
        } else {
            $where = array('is_hot'=>1,'is_active'=>1,'secid'=>$secid);
        }
        $hotlist = $this->field('id,name,shortname,description,thumbnails,secid')->order('date_joined desc')->where($where)->limit($limit)->select();
        return $hotlist;
    }
    
    public function recommend($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_active'=>1,'is_recommend'=>1);
        } else {
            $where = array('is_active'=>1,'is_recommend'=>1,'secid'=>$secid);
        }
        $recommendctm = $this->field('id,name,description,thumbnails,secid,description,date_joined')->where($where)->order('date_joined desc')->limit($limit)->select();
        return $recommendctm;
    }
    
    public function newest($limit,$parameter,$secid) {
        if($secid==0) {
            $where=array('is_active'=>1);
        } else {
            $where = array('is_active'=>1,'secid'=>$secid);
        }
        $newctm = $this->field('id,name,thumbnails')->where($where)->order("date_joined desc")->limit($limit)->select();
        return $newctm;
    }
}