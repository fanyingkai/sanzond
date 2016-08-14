<?php
namespace Home\Controller;

class OrderController extends ContentController {
    /*
     * 用户订单列表
     */
    public function orderlist() {
        $uid = 1;
        $this->display('Content/orderlist');
    }
    
    /*
     * 用户订单详情
     */
    public function orderdetail() {
        $this->display('Content/orderdetail');
    }
}