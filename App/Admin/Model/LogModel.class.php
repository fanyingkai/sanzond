<?php
namespace Admin\Model;

class LogModel extends BaseModel {

    //自动完成
    protected $_auto = array(
        //自动设置为可用
        array('client_ip','get_client_ip',self::MODEL_INSERT,'callback'),
        //设置添加时间
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
    );
}