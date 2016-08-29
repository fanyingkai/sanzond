<?php
namespace Home\Model;
use Think\Model;
class ConfigModel extends Model {
    public function getconfig($name='') {
		$str = chosedb().'config';
		if(!$result = S($str)) {
			$probe = $this->field('name,value')->select();
			$result = array();
			foreach($probe as $k=>$v) {
				$result[$v['name']]=$v['value'];
			}
			S($str,$result);
		}
		if($name=='') {
			return $result;
		} else {
			return $result[$name];
		}
    }
}