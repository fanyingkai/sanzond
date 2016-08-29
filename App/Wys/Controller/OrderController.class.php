<?php
namespace Wys\Controller;

class OrderController extends WysController {
	
	public function getorder($h=0) {
		$model = D('order','Logic');
		$list = $model->getorderinfo($h);
		if(empty($list)) {
			$this->ajaxReturn(0,'order is null',0);
		} else {
			$this->ajaxReturn(1,'Ok!',$list);
		}
	}
	/**
	 * 订单状态说明
	 * G为下单，C为总部确认，S为总部发货，R为收货，O为任何异常取消状态
	 * 例子：GCS 为已经下单并且总部确认过，且已经发货的订单，GCO为总部确认后异常情况取消
	 * @param: $o:订单编号 ， $s:订单状态
	 * @return: 失败json  ,json 格式  {'status':1(0),'info':'通知的消息','data':数据体}
	 */
	public function ustatus($o,$s) {
		$model = D('order','Logic');
		$result = $model->updatestatus($o,$s);
		if($result) {
			$this->ajaxReturn(1,'ok!',0);
		} else {
			$this->ajaxReturn(0,'fail',0);
		}
	}
}