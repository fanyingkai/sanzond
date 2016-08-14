<?php
namespace Home\Controller;

class ArticleController extends ContentController{
    
    public function index() {
        $this->display('Content:articleindex');
    }
    
    public function detail($id) {
        $model = D('article','Logic');
        $ctm = $model->where(array('id'=>$id))->find();
        //判断是否关联房产动态
        $probe = M('house')->where(array('name'=>$ctm['housename']))->find();
        if(!empty($probe)) {
            //获取楼盘其他动态文章
            $other = $model->field('id,name')->where(array('housename'=>$ctm['housename']))->select();
            if(!empty($other)) {
                $this->assign('other',$other);
            }
            $this->assign('housedetail',$probe);
        }
        $this->assign('detail',$ctm);
        $this->display('Content/articledetail');
    }
}