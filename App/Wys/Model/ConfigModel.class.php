<?php
namespace Home\Model;
use Think\Model;
class ConfigModel extends Model {
    public function getconfig() {
        $probe = $this->field('name,value')->select();
        $result = array();
        foreach($probe as $k=>$v) {
            $result[$v['name']]=$v['value'];
        }
        return $result;
    }
}