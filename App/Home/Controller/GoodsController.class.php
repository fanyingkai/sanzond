<?php
namespace Home\Controller;

class GoodsController extends HomeController {
    /**
     * 得到商品对应分类列表
     * @param unknown $category
     */
    public function getcategorygoods($category) {
        $category = urldecode($category);
        $model = D('goods','Logic');
        $categorygoodslist = $model->getcategorygoods($category);
        $categorylist = $model->getgoodscategory();
        $this->assign('categoryname',$category);
        $this->assign('categoryl',$categorylist);
        $this->assign('categorygoodslist',$categorygoodslist);
        $this->display('Content/goodslist');
    }
    
    /**
     * 全部商品
     */
    public function getallgoods() {
        $model = D('goods','Logic');
        $categorygoodslist = $model->getcategorygoods();
        $categorylist = $model->getgoodscategory();
        $this->assign('categoryname','全部');
        $this->assign('categoryl',$categorylist);
        $this->assign('categorygoodslist',$categorygoodslist);
        $this->display('Content/goodslist');
    }
    
    /**
     * 商品详情页
     * @param unknown $id
     */
    public function getgoodsdetail($id) {
        $nbbm = urldecode($id);
        $model = D('goods','Logic');
        $detail = $model->getgoodsdetail($nbbm);
        $this->assign('detail',$detail);
        $this->display('Content/goodsdetail');
    }
    
    
}