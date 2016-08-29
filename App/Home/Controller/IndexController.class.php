<?php
namespace Home\Controller;
class IndexController extends HomeController {
    public function index(){
        $model = D('sangoods','Logic');
        $category = $model->getgoodscategory();
		$new = $model->getnewgoods();
		$this->assign('newgoods',$new);
        $this->assign('category',$category);
        $this->display();
    }
	
	/**
	 * 公告
	 */
	public function bulletin(){
		 $this->display('Content/bulletin');
	}
}