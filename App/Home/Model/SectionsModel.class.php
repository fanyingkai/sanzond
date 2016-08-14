<?php
namespace Home\Model;
use Think\Model;
class SectionsModel extends Model {
    
    /*
     * 无限级分类实现
     */
    public function sectionstree() {
        $data = $this->order('sort')->select();
        return $this->resort($data);
    }
    
	public function resort($data,$parent=0,$level=0) {
		static $ret=array();
		foreach ($data as $k => $v)
		{
			if($v['parent']==$parent)
			{
				$v['level']=$level;
				$ret[]=$v;
				$this->resort($data,$v['id'],$level+1);
			}
		}
		return $ret;
	}
    
    /*
     * 获取全部顶级分类
     */
    public function getAllparent() {
        $parent = $this->field('id,name,url')->order('sort')->where(array('parent'=>'0','is_active'=>'1'))->select();
        return $parent;
    }
}