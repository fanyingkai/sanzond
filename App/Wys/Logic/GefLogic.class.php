<?php
namespace Wys\Logic;
use Think\Model;

class GefLogic extends Model {
	
	/**
	 * 得到订单信息，并更新是否导出状态，记录导出操作日志
	 * 数据参照格式 "发货单据号\t开票客户\t物料编码\t物料名称\t规格\t生产厂商\t单位\t数量\t订单日期\n";
	 */
	public function getorderinfo($where) {
		
	}
}