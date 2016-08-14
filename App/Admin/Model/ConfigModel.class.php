<?php
namespace Admin\Model;

class ConfigModel extends BaseModel{
    protected $_validate = array(
        array('name','require','配置名称不得为空！',self::MUST_VALIDATE),
        array('name',0,'配置名称不得重复',self::MUST_VALIDATE,'unique',self::MODEL_INSERT),
    );
    //自动完成
    protected $_auto = array(
        //设置添加时间
        array('date_update','auto_date_now',self::MODEL_INSERT,'callback'),
    );
}