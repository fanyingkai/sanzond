<?php
namespace Admin\Model;

class WidgetModel extends BaseModel {
    protected $_validate = array(
        array('name','require','名称不得为空！',self::MUST_VALIDATE),
        array('logicname','require','逻辑名不能为空',self::MUST_VALIDATE),
        array('name',0,'名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );
    
    //自动完成
    protected $_auto = array(
        //自动设置为可用
        array('is_active','1'),
        //设置添加时间
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
        array('founder','getusername',self::MODEL_INSERT,'callback'),
        array('founder_id','getuid',self::MODEL_INSERT,'callback'),
    );
}