<?php
namespace Admin\Controller;

class WidgetController extends AdminController{
    
    public function index() {
        $list = M('widget')->select();
        $this->assign('widget',$list);
        $this->display();
    }
    
    public function add() {
        $this->display();
    }
    
    public function edit($id) {
        $widget = M('widget')->where(array('id'=>$id))->find();
        $this->assign('widget',$widget);
        $this->display();
    }
}