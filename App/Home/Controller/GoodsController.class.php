<?php
namespace Home\Controller;

class GoodsController extends HomeController {
    public function getcategorygoods($category) {
        $category = urldecode($category);
        $model = D('goods','Logic');
        $categorygoodslist = $model->getcategorygoods($category);
        $this->assign('categorygoodslist',$categorygoodslist);
        $this->display()
    }
}