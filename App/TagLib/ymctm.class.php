<?php
namespace TagLib;
use Think\Template\TagLib;

class ymctm extends TagLib{
    protected $tags   =  array(
        // 定义标签
        'ctm' => array('attr'=>'name,action,parameter,item,limit,key,secid','close'=>1), //action 代表对应内容模型下的方法
        'ctmform'=>array('attr'=>'name,item,key','close'=>1), 
    );
    
    public function _ctm($tag,$content) {
        //获取变量
        $logic     = $tag['name']; //内容模型逻辑名称
        $action    = $tag['action']; //对应内容模型方法
        $parameter = !empty($tag['parameter'])?$tag['parameter']:array();  //方法参数
        $item   = $tag['item'];
        $limit  = $tag['limit'];
        $secid  = !empty($tag['secid'])?$tag['secid']:0;
        $key    = !empty($tag['key'])?$tag['key']:'key';
        //标签体拼接php代码
        $str = '<?php ';
        $str .= '$ctm = D("'.$logic.'","Logic")->'.$action.'('.$limit.','.$parameter.','.$secid.');';
        $str .= 'foreach($ctm as $'.$key.'=>$'.$item.'): ?>';
        $str .= $this->tpl->parse($content);
        $str .= '<?php endforeach; ?>';
        return $str;
    }
    
    public function _ctmform($tag,$content) {
        $logic = $tag['name'];
        $item  = $tag['item']; 
        $key  = !empty($tag['key'])?$tag['key']:'key';
        $str  = '<?php ';
        $str .= '$ctm = D("'.$logic.'","Logic")->Fields();';
        $str .= 'foreach($ctm as $'.$key.'=>$'.$item.'): ?>';
        $str .= $this->tpl->parse($content);
        $str .= '<?php endforeach; ?>';
        return $str;
    }
}