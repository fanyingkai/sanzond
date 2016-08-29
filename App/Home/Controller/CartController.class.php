<?php
namespace Home\Controller;

class CartController extends HomeController {
    
    /**
     * 处理前台数量为0的情况
     */
    public function dealzero() {
        $nbbm = $_POST['nbbm'];
        if(session('?cart')) {
            $arr = session('cart');
            if(isset($arr[$nbbm])) {
                unset($arr[$nbbm]);
                session('cart',$arr);
            }
        }
        $this->ajaxReturn(1, 0, 0);
    }
    
    public function addcart() {
        $nbbm = $_POST['nbbm'];
        $quantity = $_POST['quantity'];
        $totalprice = $_POST['totalprice'];
        $totalquantity = $_POST['totalquantity'];
        session('totalprice',$totalprice);
        session('totalquantity',$totalquantity);
        if(session('?cart')) {
            $arr = session('cart');
            if(isset($arr[$nbbm])) {
                $arr[$nbbm] = intval($arr[$nbbm]) + intval($quantity);
            } else {
                $arr[$nbbm] = $quantity;
            }
        } else {
            $arr[$nbbm] = $quantity;
        }
        session('cart',$arr);
        $this->ajaxReturn(1, 0, 0);
    }
    
    public function subcart() {
        $nbbm = $_POST['nbbm'];
        $quantity = $_POST['quantity'];
        $totalprice = $_POST['totalprice'];
        $totalquantity = $_POST['totalquantity'];
        session('totalprice',$totalprice);
        session('totalquantity',$totalquantity);
        $arr = session('cart');
        if(isset($arr[$nbbm])) {
            $arr[$nbbm] = intval($arr[$nbbm]) - intval($quantity);
            if($arr[$nbbm] == 0) {
                unset($arr[$nbbm]);
            }
        }
        session('cart',$arr);
        $this->ajaxReturn(1, 0, 0);
    }
    
    /**
     * 去确认页面
     */
    public function confirmcart() {
        $model = D('cart','Logic');
		$userm = D('sanuser','Logic');
        $result = $model->getcartlist();
		$contacts = $userm->getUsercontact();
		//var_dump($contacts);die;
		$this->assign('contacts',$contacts);
		$this->assign('totalprice',$result['totalprice']);
		$this->assign('totalquantity',$result['totalquantity']);
        $this->assign('goodslist',$result['cartlist']);
        $this->display('Content/confirmO');
    }
    
    
    public function gettotal() {
        if(session('?totalprice'))
			$totalprice = session('totalprice');
		else
			$totalprice = 0;
		if(session('?totalquantity'))
			$totalquantity = session('totalquantity');
		else
			$totalquantity = 0;
		$data['totalprice'] = $totalprice;
		$data['totalquantity'] = $totalquantity;
		$this->ajaxReturn(1,0,$data);
    }
}