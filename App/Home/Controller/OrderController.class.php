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
		if($_POST['address']=='') $this->error('地址不能为空',0,1);
		if($_POST['name']=='') $this->error('联系人姓名不能为空',0,1);
		if($_POST['phone']=='') $this->error('手机不能为空',0,1);
		$model = D('order','Logic');
		$result = $model->createorder();
		if($result['errcode'] == 0) {
			$this->message_self($result['orderinfo']['ordercode'],'G');
			$this->assign('orderinfo',$result['orderinfo']);
		} else {
			$this->error($result['info']);
		}
		$this->display('Content/success');
	}
	
	/**
	 * 订单生成成功后通知
	 */
	public function message_self($ordercode,$status) {
		
		switch ($status) {
			case 'G':
				$tpl = D('Config')->getconfig('gnotiftpl');
				break;
			case 'O':
				$tpl = D('Config')->getconfig('onotiftpl');
				break;
			case 'R':
				$tpl = D('Config')->getconfig('rnotiftpl');
				break;
			default:break;
		}
		$tys = new \Common\Docking\Tyswx();
		$weobj = new WxqController();
		$backurl = "jf.sanzond.com/Home/Auth/authorder";
		$url = $weobj->getOAuth2url($backurl,$ordercode);
		$content = str_replace('{ordercode}',$ordercode,$tpl);
		$picurl = 'http://test.sanzond.com/Public/Static/Home/img/headerlogo.png';
		$tys->sendNews('订单生成成功',$content,$url,$picurl,getuserid());
		$this->message_company($ordercode,$status);
	}
	
	/**
	 * 通知公司人员
	 */
	public function message_company($ordercode,$status) {
		$model = D('Config');
		switch ($status) {
			case 'G':
				$tpl = $model->getconfig('cgnotiftpl');
				break;
			case 'O':
				$tpl = $model->getconfig('conotiftpl');
				break;
			case 'R':
				$tpl = $model->getconfig('crnotiftpl');
				break;
			default:
				return;
				break;
		}
		$order = D('order','Logic');
		$detailinfo = $order->getorderinfo($ordercode);
		$notifystaff = $model->getconfig('notifystaff');
		$tys = new \Common\Docking\Tyswx();
		$uid = getuserid();
		$model = D('sanuser','Logic');
		$userinfo = $model->getuserinfo();
		$name = $userinfo['name'];
		$msg = str_replace('{name}',trim($name),$tpl);
		$msg = str_replace('{cname}',trim($detailinfo['client']),$msg);
		$msg = str_replace('{ordercode}',$detailinfo['ordercode'],$msg);
		$msg = str_replace('{time}',date("Y-m-d H:i:s",$detailinfo['date_joined']),$msg);
		$msg = str_replace('{varietynum}',$detailinfo['totalquantity'],$msg);
		$msg = str_replace('{status}',$this->getstatusstr($status),$msg);
		$tys->sendText($notifystaff,$msg);
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
			case 'C':
				$where = array('status'=>'GC');
				break;
			case 'R':
				$where = array('status'=>'GCSR');
				break;
			case 'O':
				$where = array('status'=>'GO');
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
				$this->message_self($ordercode,'O');
				$this->ajaxReturn(1,0,0);
			} else {
				$errimg = $model->getError();
				$this->ajaxReturn(0,$errimg,0);
			}
		}
	}
	
	/**
	 * 确认收货
	 */
	public function conreturn() {
		$ordercode = $_POST['ordercode'];
		$model = M('order');
		$statusd = M('order')->field('status')->where("ordercode = '{$ordercode}'")->find();
		$status = $statusd['status'];
		if($status!="GCS") {
			$this->ajaxReturn(0,'总部未发货，无法确认收货',0);
		}
		$newstatus = $status.'R';
		$result = $model->where("ordercode = '{$ordercode}'")->setField('status',$newstatus);
		if($result) {
			$this->message_self($ordercode,'R');
			$this->ajaxReturn(1,0,0);
		} else {
			$errimg = $model->getError();
			$this->ajaxReturn(0,$errimg,0);
		}
	}
	
	public function getstatusstr($status) {
		switch ($status) {
			case 'G':
				$str = '下订单';
				break;
			case 'GC':
				$str = '总部已确认';
				break;
			case 'GCS':
				$str = '总部已发货';
				break;
			case 'GCSR':
				$str = '确认收货';
				break;
			default:
				$str = '已取消';
				break;
		}
		return $str;
	}
}