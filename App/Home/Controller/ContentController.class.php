<?php
namespace Home\Controller;

class ContentController extends HomeController {
    public function detail($logic,$id) {
        $model = D($logic,'Logic');
        $ctm = $model->where(array('id'=>$id))->find();
        if(empty($ctm)) {
            $this->error('出错了');
        } else {
            $this->assign('detail',$ctm);
            $tpl = $logic.'detail';
            $this->display($tpl);
        }
    }
}