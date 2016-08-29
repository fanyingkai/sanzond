<?php
namespace Wys\Logic;
use Think\Model;

class OrderLogic extends Model {
	/**
	 * 得到订单信息，并更新是否导出状态，记录导出操作日志
	 * $h 距离的小时数
	 * 数据参照格式 "发货单据号\t开票客户\t物料编码\t物料名称\t规格\t生产厂商\t单位\t数量\t订单日期\n";
	 */
	public function getorderinfo($h) {
		if($h==0) {
			$where = "1=1 and downnum =0";
			$whereo = $where;
		} else {
			$etime = time();
			$stime = $etime - ($h * 3600);
			$where = "a.date_joined between {$stime} and {$etime} and downnum = 0";
			$whereo = "date_joined between {$stime} and {$etime}";
		}
		//M('order')->where($where)->setInc('downnum',1);
		$where = $where.' and a.ordercode=b.ordercode';
		$list = M()->table('wy_order b,wy_orderdetail a')->field('a.*,b.client')->where($where)->order('ordercode')->select();
		M('order')->where($whereo)->setInc('downnum',1);
		return $list;
	}
	
	/**
	 * 更新订单状态
	 */
	public function updatestatus($o,$s){
		$where = "ordercode = '{$o}'";
		$order = $this->where($where)->find();
		if(!empty($order)) {
			$result = $this->where($where)->setField('status',$s);
			if($result) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}