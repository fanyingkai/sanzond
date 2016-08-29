<?php
namespace Admin\Logic;

class bannerLogic extends BaseLogic {
    protected  $_validate= array(
        array('name','require','名称不得为空！',self::MUST_VALIDATE),
        array('name',0,'名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
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
	//满足删除规则
    public function trash() {
        $list = $this->field('id,img_url as name,updater,date_update')->where(array('is_active'=>'3'))->select();
        return $list;
    }
}