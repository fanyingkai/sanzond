<?php
namespace Home\Logic;

class CartLogic extends BaseLogic {
    /**
     * 读取session中的商品
     */
    public function getcartlist() {
        $goods = D('goods','Logic');
        if(!session('?cart')) return;
        $arr = session('cart');
        $userid = $this->getuserid();
        $cartlist = array();
        $i = 0;
        foreach($arr as $k=>$v) {
            $detail = $goods->getgoodsdetaily($k);
            $cartlist[$i]['nbbm'] = $detail['nbbm'];
            $cartlist[$i]['ypm'] = $detail['ypm'];
            $cartlist[$i]['gg'] = $detail['gg'];
			$cartlist[$i]['ypdj'] = $detail['ypdj'];
            $cartlist[$i]['lsj'] = $detail['lsj'];
            $cartlist[$i]['ypcj'] = $detail['ypcj'];
            $cartlist[$i]['kcs'] = $detail['kcs'];
            $cartlist[$i]['quantity'] = $v;
            $i++;
        }
        return $cartlist;
    }
	
}