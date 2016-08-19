<?php
namespace Wys\Controller;

class GefController extends WysController {
	public function goef() {
		header('Content-type: text/html; charset=utf-8');
		header("Content-type:application/vnd.ms-excel;charset=UTF-8"); 
		header("Content-Disposition:filename=order.xls");
		$top="发货单据号\t开票客户\t物料编码\t物料名称\t规格\t生产厂商\t单位\t数量\t订单日期\n";
		$top = mb_convert_encoding($top,'gbk','utf-8');
		echo $top;
		$model = D('gef','Logic');
		$list = $model->getorderlist($where);
	}
}