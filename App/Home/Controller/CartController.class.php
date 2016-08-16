<?php
namespace Home\Controller;

class CartController extends HomeController {
    /**
     * 保存购物车
     * $return json{'status':status,'info':info,'data':data}
     */
    /*
     public function savecart() {
     session('totalprice',$_POST['totalprice']);
     unset($_POST['totalprice']);
     session('totalquantity',$_POST['totalquantity']);
     unset($_POST['totalquantity']);
     if(session('?cart')) {
     $arr = session('cart');
     foreach($_POST as $k=>$v) {
     $arr[$k] = $v;
     }
     session('cart',$arr);
     } else {
     session('cart',$_POST);
     }
     $this->ajaxReturn(1, 'ok', 0);
     } */
    
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
     * 调式函数，调试购物车
     * @param number $clear
     */
    public function getsession($clear=0) {
        var_dump($_SESSION);
        if($clear == 1) {
            session(null);
        }
    }
    
    /**
     * 去确认页面
     */
    public function confirmcart() {
        $model = D('cart','Logic');
        $goodslist = $model->getcartlist();
        $this->assign('goodslist',$goodslist);
        $this->display('Content/confirmO');
    }
    
    
    public function test() {
        echo ACTION_NAME;
    }
}