<?php
namespace Home\Logic;

class GoodsLogic extends BaseLogic{
    /**
     * 获取商品分类
     */
    public function getgoodscategory(){
        $category = $this->field('distinct dmmc')->order('dmmc desc')->select();
        return $category;
    }
    
    /**
     * 获取分类商品
     */
    public function getcategorygoods($categoryname) {
        $goodslist = $this->where(array('dmmc'=>$categoryname))->select();
        return $goodslist;
    }
}