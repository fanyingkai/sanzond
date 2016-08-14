<?php
namespace Home\Controller;

class IndexController extends HomeController {
    public function index(){
        $model = D('goods','Logic');
        $category = $model->getgoodscategory();
        $this->assign('category',$category);
        $this->display();
    }
}