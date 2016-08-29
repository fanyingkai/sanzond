<?php
namespace Wys\Controller;

class GefController extends WysController {
	public function goef($h=0) {
		header('Content-type: text/html; charset=utf-8');
		header("Content-type:application/vnd.ms-excel;charset=UTF-8"); 
		header("Content-Disposition:filename=order.xls");
		$top="发货单据号\t开票客户\t物料编码\t物料名称\t规格\t生产厂商\t单位\t数量\t订单日期\n";
		$top = mb_convert_encoding($top,'gbk','utf-8');
		$model = D('order','Logic');
		$list = $model->getorderinfo($h);
		echo $top;
		foreach($list as $k=>$v) {
			$time = date("Y-m-d",$v['date_joined']);
			$str = "{$v['ordercode']}\t{$v['client']}\t{$v['gid']}\t{$v['gname']}\t{$v['gg']}\t{$v['factory']}\t{$v['unit']}\t{$v['quantity']}\t{$time}\n";
			$str = mb_convert_encoding($str,'gbk','utf-8');
			echo $str;
		}
	}
}