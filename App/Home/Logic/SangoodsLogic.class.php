<?php
namespace Home\Logic;

class SangoodsLogic extends BaseLogic{
    /**
     * 获取商品分类
     */
    public function getgoodscategory(){
		$str = chosedb().'category';
		if(!$category = S($str)) {
			$category = $this->field('distinct dmmc')->order('dmmc desc')->select();
			S($str,$category);
		}
        return $category;
    }
    
    /**
     * 获取分类商品
	 * @param string $categoryname
     */
    public function getcategorygoods($categoryname='') {
        $field = 'nbbm,ypm,gg,lsj,ypdj,ypcj,kcs,zxdw';
        if($categoryname == '') {
            $goodslist = $this->field($field)->select();
        } else {
            $where = "dmmc = '{$categoryname}'";
            $goodslist = $this->field($field)->where($where)->select();
        }
        return $goodslist;
    }
	
	/**
	 * 按条件获取商品，并作分页处理
	 */
	public function getgoodslist($where,$page=0) {
		$num = D('config')->getconfig('pagenum');
		//$count = $this->where($where)->count();
		$start = $num * $page;
		$field = "ypm,gg,ypdj,lsj,kcs,nbbm,ypcj,thumbnails";
		$list = $this->field($field)->where($where)->limit($start,$num)->select();
		if(!empty(session('cart'))) {
			$cart = session('cart');
			foreach ($cart as $k=>$v) {
				foreach($list as $lk=>$lv) {
					if($k == $lv['nbbm']) {
						$list[$lk]['quantity'] = $v;
					} else {
						$list[$lk]['quantity'] = 0;
					}
					$list[$lk]['ypdj'] = doubleval($lv['ypdj']);
					$list[$lk]['lsj'] = doubleval($vo['lsj']);
					$list[$lk]['kcs'] = intval($lv['kcs']);
					$list[$lk]['detailurl'] = U('Goods/getgoodsdetail',array('id'=>urlencode($lv['nbbm'])));
					if(isset($lv['thumbnails'])) {
						$list[$lk]['imgurl'] = '/Uploads/'.$lv['thumbnails'];
					} else {
						$list[$lk]['imgurl'] = C('TMPL_PARSE_STRING')['__PUBLIC__'].'/img/none.png';
					}
				}
			}
		} else {
			foreach ($list as $ke=>$vo) {
				$list[$ke]['ypdj'] = doubleval($vo['ypdj']);
				$list[$ke]['lsj'] = doubleval($vo['lsj']);
				$list[$ke]['kcs'] = intval($vo['kcs']);
				$list[$ke]['quantity'] = 0;
				$list[$ke]['detailurl'] = U('Goods/getgoodsdetail',array('id'=>urlencode($vo['nbbm'])));
				if(isset($vo['thumbnails'])) {
					$list[$ke]['imgurl'] = '/Uploads/'.$vo['thumbnails'];
				} else {
					$list[$ke]['imgurl'] = C('TMPL_PARSE_STRING')['__PUBLIC__'].'/img/none.png';
				}
			}
		}
		//var_dump($list);die;
		return $list;
		
	}
    
    /**
     * 得到商品详情
     * @param string $nbbm
     */
    public function getgoodsdetail($nbbm) {
        $where = "nbbm = '{$nbbm}'";
        $detail = $this->where($where)->find();
        return $detail;
    }
    
	public function getnewgoods() {
		$field = "nbbm,thumbnails,ypm";
		$new = $this->field($field)->where(array('is_new'=>'1'))->limit(4)->select();
		return $new;
	}
    /**
     * 得到单个商品简单详情
	 * @param string $nbbm
     */
    public function getgoodsdetaily($nbbm) {
        $field = 'nbbm,ypm,gg,lsj,ypcj,kcs,ypdj,thumbnails,zxdw';
        $where = "nbbm = '{$nbbm}'";
        $detail = $this->where($where)->field($field)->find();
        return $detail;
    }
}