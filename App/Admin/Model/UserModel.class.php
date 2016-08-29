<?php
namespace Admin\Model;

class UserModel extends BaseModel{
    //自动验证
    protected $_validate = array(
        array('username','require','用户名不得为空！',self::MUST_VALIDATE),
        array('username',0,'用户名不得重复',self::MUST_VALIDATE,'unique',self::MODEL_INSERT),
        array('phone','require','手机号不得为空',self::MUST_VALIDATE),
        array('phone','/^1[34578]{1}\d{9}$/','手机号码格式不正确',self::MUST_VALIDATE,'regex'),
        array('phone',0,'手机号不得重复',self::MUST_VALIDATE,'unique',self::MODEL_INSERT),
        array('email','require','邮箱不得为空',self::MUST_VALIDATE),
        array('email','email','邮箱格式不正确',self::MUST_VALIDATE),
        array('phone',0,'邮箱不得重复',self::MUST_VALIDATE,'unique',self::MODEL_INSERT),
        array('is_active','number','是否可用为数字标记！错误请联系管理员'),
    );
    
    //自动完成
    protected $_auto = array(
        //自动设置为可用
        array('is_active','1'),
        //设置添加时间
        array('password','password',self::MODEL_BOTH,'function'),
        array('date_joined','auto_date_now',self::MODEL_INSERT,'callback'),
        array('date_update','auto_date_now',self::MODEL_UPDATE,'callback'),
    );
    
    protected function _after_insert($data,$options) {
       
    }
    
    protected function _before_update($data, $options) {
		
    }
}