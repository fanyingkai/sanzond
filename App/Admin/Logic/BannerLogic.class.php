<?php
namespace Admin\Logic;

class bannerLogic extends BaseLogic {
    protected  $_validate= array(
        array('name','require','名称不得为空！',self::MUST_VALIDATE),
        array('name',0,'名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );

    //自动完成
    protected $_auto = array(
        array('date_joined',time,self::MODEL_INSERT,function),
		array('create_id',session('uid'),self::MODEL_INSERT),
    );
	
	//满足删除规则
    public function trash() {
        $list = $this->field('id,img_url as name,updater,date_update')->where(array('is_active'=>'3'))->select();
        return $list;
    }
}