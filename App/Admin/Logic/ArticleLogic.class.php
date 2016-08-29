<?php
namespace Admin\Logic;

class ArticleLogic extends BaseLogic{
    //自动验证
    protected $_validate = array(
        array('name','require','文字名称不得为空！',self::MUST_VALIDATE),
        array('name',0,'文章名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );
    
    //自动完成
    protected $_auto = array(
        //设置添加时间
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
        array('date_update','auto_date_now',self::MODEL_UPDATE,'callback'),
        array('founder_uid','getuid',self::MODEL_INSERT,'callback'),
        array('founder','getusername',self::MODEL_INSERT,'callback'),
        array('updater_uid','getuid',self::MODEL_UPDATE,'callback'),
        array('updater','getusername',self::MODEL_UPDATE,'callback'),
    );
    
	//实现查询规则
    public function search($secid,$keyword='') {
        //$where = "name like '%{$keyword}%' or description like '%{$keyword}%' or content like '%{$keyword}%'";
        if($secid==0) {
            $map = array(
                'name'=>array('like',"%{$keyword}%"),
                'description'=>array('like',"%{$keyword}%"),
                'content'=>array('like',"%{$keyword}%"),
                'shortname'=>array('like',"%{$keyword}%"),
                '_logic'=>'OR',
            );
        } else {
            $where = array(
                'name'=>array('like',"%{$keyword}%"),
                'description'=>array('like',"%{$keyword}%"),
                'content'=>array('like',"%{$keyword}%"),
                'shortname'=>array('like',"%{$keyword}%"),
                '_logic'=>'OR',
            );
            $map = array(
                'secid'=>$secid,
                '_complex'=>$where,
                '_logic'=>'AND',
            );
        }
        
        $count = $this->where($map)->count();
        //echo $this->getLastSql();die;
        //var_dump($ctmlist);die;
        $a = array(
            'count'=>$count,
            'map'=>$map,
        );
        return $a;
    }
    
	//实现删除规则
    public function trash() {
        $list = $this->field('id,name,updater,date_update')->where(array('is_active'=>'3'))->select();
        return $list;
    }
}