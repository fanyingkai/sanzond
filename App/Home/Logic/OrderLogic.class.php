<?php
namespace Home\Logic;

class orderLogic extends BaseLogic {
	
	/**
	 * 生成并保存订单，返回订单信息
	 */
    public function createorder() {
		if(!session('?cart')) return;
		$ordercode = $this->createordercode();
		//生成并保存详情
		$goods = D('goods','Logic');
        $arr = session('cart');
        $userid = getuserid();
        $cartlist = array();
        $i = 0;
		$totalquantity = 0;
		$totalprice = 0;
        foreach($arr as $k=>$v) {
            $gdetail = $goods->getgoodsdetaily($k);
			$cartlist[$i]['ordercode']=$ordercode;
            $cartlist[$i]['gid'] = $gdetail['nbbm'];
            $cartlist[$i]['gname'] = $gdetail['ypm'];
            $cartlist[$i]['gg'] = $gdetail['gg'];
			$cartlist[$i]['unit'] = $gdetail['zxdw'];
			$cartlist[$i]['price'] =$gdetail['ypdj'];
            $cartlist[$i]['rsp'] = $gdetail['lsj'];
            $cartlist[$i]['factory'] = $gdetail['ypcj'];
            $cartlist[$i]['quantity'] = $v;
			$cartlist[$i]['date_joined'] = time();
			$totalquantity = $totalquantity + $v;
			$totalprice = floatval($totalprice) + floatval($v * $gdetail['ypdj']);
            $i++;
        }
		$result = M('orderdetail')->addAll($cartlist);
		if($result) {
			//保存订单详情成功，生成主体订单
			$order['ordercode'] = $ordercode;
			$order['totalquantity'] = $totalquantity;
			$order['totalprice'] = $totalprice;
			$order['status'] = 'G';
			$order['create_uid'] = $userid;
			$order['phone'] = $_POST['phone'];
			$order['contact'] = $_POST['name'];
			$order['address'] = $_POST['address'];
			$order['date_joined'] = time();
			$oresult = $this->add($order);
			if($oresult) {
				$arr['errcode'] = 0;
				$arr['orderinfo'] = $order;
				//记录新的收货地址
				$this->savecontact($_POST);
				//订单生成后记录日志
				$remark = '订单号:'.$ordercode;
				writelog('订单生成','订单',$remark);
				session('cart',null);
				session('totalprice',null);
				session('totalquantity',null);
			} else {
				$arr['errcode'] = 1;
				$arr['info'] = '保存订单主体失败';
			}
		} else {
			$arr['errcode'] = 1;
			$arr['info'] = '保存订单详情失败';
		}
		return $arr;
	}
	
	/**
     * 生成订单编号
     */
	public function createordercode() {
		$time = time();
		$uid = getuid();
		$ordercode = 'wx'.$uid.$time;
		$where = "ordercode = '{$ordercode}'";
		$count = M('order')->where($where)->count();
		if($count > 0) {
			$ordercode = $ordercode.'cf';
		}
		return $ordercode;
	}
	
	/**
	 * 得到订单详情页
	 */
	public function getorderdetail($ordercode) {
		$where = "ordercode = '{$ordercode}'";
		$order = $this->where($where)->find();
		$field = 'quantity,price,gname';
		$detail = M('orderdetail')->field($field)->where($where)->select();
		$result['order'] = $order;
		$result['detail'] = $detail;
		return $result;
	}
	
	/**
	 * 得到对应用户的订单列表
	 */
	public function getorderlist() {
		$userid = getuserid();
		$where = "create_uid = '{$userid}'";
		$field = 'ordercode,totalprice,date_joined';
		$orderlist = $this->order('date_joined desc')->where($where)->limit(20)->select();
		return $orderlist;
	}
	
	/**
	 * 得到对应用户的订单列表，并作分页处理
	 */
	public function getorderlst($where,$page) {
		$num = 5;
		$start = $num * $page;
		$userid = getuserid();
		$where = $where .' AND '."create_uid ={$userid}";
		$field = 'ordercode,totalprice,date_joined';
		$list=$this->where($where)->field($field)->limit($start,$num)->select();
		foreach($list as $k=>$v) {
			$list[$k]['odurl'] = U('Order/detail',array('ordercode'=>$v['ordercode']));
			$list[$k]['date_joined'] = date('Y-m-d H:i:s',$v['date_joined']);
		}
		return $list;
	}
	
	public function gettypeolist($where) {
		$where['create_uid']=getuserid();
		$field = 'ordercode,totalprice,date_joined';
		$list = $this->where($where)->field($field)->select();
		return $list;
	}
	/**
	 * 保存联系方式
	 */
	public function savecontact($arr) {
		$model = D('user_contacts');
		$address = $arr['address'];
		$phone = $arr['phone'];
		$name = $arr['name'];
		$where = "name='{$name}' and phone='{$phone}' and address='{$address}' ";
		$result = $model->where($where)->find();
		if(empty($result)) {
			$arr['userid'] = getuserid();
			$model->add($arr);
		}
		return;
	}
}