<?php
namespace Admin\Controller;

class SectionsController extends AdminController{
    public function index() {
        $sections = D('Sections');
        $sectionList = $sections->sectionstree();
        $this->assign('sectionList',$sectionList);
        $this->display();
    }

    public function addsections() {
        $parent = D('Sections');
        $sectionList = $parent->sectionstree();
        $this->assign('sectionList',$sectionList);
        $this->display();
    }

    public function editsections($secid) {
        $parent = D('Sections');
        $secinfo = $parent->where(array('id'=>$secid))->find();
        $sectionList = $parent->sectionstree();
        $this->assign('secinfo',$secinfo);
        $this->assign('sectionList',$sectionList);
        $this->display();
    }
}