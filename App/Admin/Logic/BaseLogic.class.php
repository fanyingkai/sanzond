<?php
namespace Admin\Logic;
use Admin\Model\BaseModel;

class BaseLogic extends BaseModel{
    public function displayother() {}
    public function displaylistother() {}
    public function displayeditother() {}
    public function trash(){}
    public function search($secid,$keyword=''){}
    
    //得到数据表所有字段
    public function Fields() {
        $fields = $this->getDbFields();
        $a = array();
        foreach($fields as $k=>$v) {
            $a[][$v] = $v;
        }
        return $a;
    }
}