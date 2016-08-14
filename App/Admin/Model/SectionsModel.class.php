<?php
namespace Admin\Model;

class SectionsModel extends BaseModel {
    //自动验证
    protected $_validate = array(
        array('name','require','栏目名称不得为空！',1),
        array('name',0,'栏目名称不得重复',1,'unique',1),
    );
    
    //自动完成
    protected $_auto = array(
        //自动设置为可用
        array('is_active','1'),
        //设置添加时间
        array('date_joined','auto_date_now',1,'callback'),
    );
    
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
    
	
    public function childid($sectionid)
    {
        $data=$this->select();
        return $this->getchildid($data,$sectionid);
    }
    
    public function getchildid($data,$parent)
    {
        static $ret=array();
        foreach ($data as $k=>$v) {
            if($v['parent']==$parent)
            {
                $ret[]=$v['id'];
                $this->getchildid($data,$v['id']);
            }
        }
        return $ret;
    }
    
    
    public function _before_delete($options)
    {
        //单独删除时候id的值，是一个字符串，是一个单独的id
        //$options['where']['id']    int(5)
        if(is_array($options['where']['id']))
        {
            $arr=explode(',', $options['where']['id'][1]);
            $soncates=array();
            foreach ($arr as $k=>$v)
            {
                $soncates2=$this->childid($v);
                $soncates=array_merge($soncates,$soncates2);
            }
            $soncates=array_unique($soncates);
            $chilrenids=implode(',', $soncates);
    
        }else
        {
            $chilrenids=$this->childid($options['where']['id']);
            $chilrenids=implode(',', $chilrenids);
            	
        }
    
        if($chilrenids)
        {
            $this->execute("delete from cs_cate where id in($chilrenids)");
        }
    }
    
    /*
     * 获取全部顶级分类
     */
    public function getAllparent() {
        $parent = $this->where(array('parent'=>'0','is_active'=>'1'))->select();
        return $parent;
    }
}