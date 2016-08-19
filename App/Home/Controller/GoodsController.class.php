<?php
namespace Home\Controller;

class GoodsController extends HomeController {
    /**
     * 得到商品对应分类列表
     * @param string $category
     */
    public function getcategorygoods($category) {
        $category = urldecode($category);
        $model = D('goods','Logic');
        $categorygoodslist = $model->getcategorygoods($category);
        $categorylist = $model->getgoodscategory();
        $this->assign('categoryname',$category);
        $this->assign('categoryl',$categorylist);
        $this->assign('categorygoodslist',$categorygoodslist);
        $this->assign('carturl',U('Goods/gocart'));
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
        $this->assign('carturl',U('Goods/gocart'));
        $this->display('Content/goodslist');
    }
    
	/**
	 * 得到分页商品列表
	 * $return json
	 */
	public function getgoodslist() {
		$where = $_POST['where'];
		if(strstr($where,'全部')) $where = 0;
		
		$page = $_POST['page'];
		$model = D('goods','Logic');
		$list = $model->getgoodslist($where,$page);
		if(!empty($list)) {
			$this->ajaxReturn(1,0,$list);
		} else {
			$this->ajaxReturn(0,'查无此商品',0);
		}
	}
    /**
     * 商品详情页
     * @param string $id
     */
    public function getgoodsdetail($id) {
        $nbbm = urldecode($id);
        $model = D('goods','Logic');
        $detail = $model->getgoodsdetail($nbbm);
        $this->assign('detail',$detail);
        $this->assign('carturl',U('Goods/gocart'));
        $this->display('Content/goodsdetail');
    }
    
	/**
	 * 去购物车
	 */
    public function gocart() {
        $model = D('cart','Logic');
        $cartlist = $model->getcartlist();
        $this->assign('carturl',U('Cart/confirmcart'));
        $this->assign('cartlist',$cartlist);
        $this->display('Content/cart');
    }
	
	/**
	 * 查询商品数据
	 */
	public function search() {
		$model = D('goods','Logic');
		$keyword = $_POST['keyword'];
		$categorylist = $model->getgoodscategory();
		$where = "ypm like '%{$keyword}%' or ypcj like '%{$keyword}%' or gg like '%{$keyword}%' or dmmc like '%{$keyword}%'";
		$this->assign('where',$where);
		$this->assign('categoryl',$categorylist);
		$this->display('Content/goodslist');
	}
	public function test() {
		//$list = M('goods')->limit(8,16)->select();
		//var_dump($list);die;
		$cart = array();
		foreach($cart as $k=>$v) {
			echo 'aa';
		}
		echo C('TMPL_PARSE_STRING')['__PUBLIC__'];
	}
}