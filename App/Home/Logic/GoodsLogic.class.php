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
    public function getcategorygoods($categoryname='') {
        $field = 'nbbm,ypm,gg,lsj,ypcj,kcs';
        if($categoryname == '') {
            $goodslist = $this->field($field)->select();
        } else {
            $where = "dmmc = '{$categoryname}'";
            $goodslist = $this->field($field)->where($where)->select();
        }
        return $goodslist;
    }
    
    /**
     * 得到商品详情
     * @param unknown $nbbm
     */
    public function getgoodsdetail($nbbm) {
        $where = "nbbm = '{$nbbm}'";
        $detail = $this->where($where)->find();
        return $detail;
    }
}