<?php
namespace Home\Controller;
/**
 * 订单状态说明
 * G为下单，C为总部确认，S为总部发货，R为收货，O为任何异常取消状态
 * 例子：GCS 为已经下单并且总部确认过，且已经发货的订单，GCO为总部确认后异常情况取消
 */
class OrderController extends ContentController {
	/**
	 * 生成订单	
	 */
	public function createorder() {
		if(!session('?cart')) $this->error('无商品信息可供生成订单',U('Goods/getallgoods'));
		$model = D('order','Logic');
		$result = $model->createorder();
		if($result['errcode'] == 0) {
			$this->assign('orderinfo',$result['orderinfo']);
		} else {
			$this->error($result['info']);
		}
		$this->display('Content/success');
	}
    /**
     * 用户订单列表
     */
    public function orderlist() {
		$model = D('order','Logic');
		$orderlist = $model->getorderlist();
		$this->assign('orderlist',$orderlist);
		$this->assign('statusinfo','0');
        $this->display('Content/orderlist');
    }
    
	public function gettypeolist($type) {
		$type = urldecode($type);
		switch($type) {
			case 'WC':
				$where = array('status'=>'G');
				break;
			case 'WR':
				$where = array('status'=>'GCS');
				break;
			default:break;
		}
		$model = D('order','Logic');
		$list = $model->gettypeolist($where);
		$this->assign('orderlist',$list);
		$this->assign('statusinfo',$type);
		$this->display('Content/orderlist');
	}
	
    /**
     * 用户订单详情
     */
    public function detail($ordercode) {
		$model = D('order','Logic');
		$result= $model->getorderdetail($ordercode);
		$detail = $result['detail'];
		$order = $result['order'];
		$this->assign('detail',$detail);
		$this->assign('order',$order);
        $this->display('Content/orderdetail');
    }
	
	/**
	 * 取消订单
	 */
	public function cancel(){
		$ordercode = $_POST['ordercode'];
		$model = M('order');
		$statusd = M('order')->field('status')->where("ordercode = '{$ordercode}'")->find();
		$status = $statusd['status'];
		if(strstr($status,'C')) {
			$this->ajaxReturn(0,'该订单总部审核通过，无法取消，请点击右上角联系相关负责人',0);
		} else {
			$newstatus = $status.'O';
			$result = $model->where("ordercode = '{$ordercode}'")->setField('status',$newstatus);
			if($result) {
				$this->ajaxReturn(1,0,0);
			} else {
				$errimg = $model->getError();
				$this->ajaxReturn(0,$errimg,0);
			}
		}
	}
}