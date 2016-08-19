<?php
namespace Home\Controller;
use Think\Controller;

class TestController extends Controller {
	
	public function clear() {
		session('totalprice',null);
		session('totalquantity',null);
		session('cart',null);
	}
	
	public function getsession() {
		var_dump($_SESSION);die;
	}
	
	public function goodstest() {
		$where = "dmmc='西药'";
		$page = 1;
		$model = D('goods','Logic');
		$list = $model->getgoodslist($where,$page);
		var_dump($list);die;
	}
	
	public function getallgoods() {
		$where = 0;
		$field = "ypm,gg,ypdj,lsj,kcs,nbbm,ypcj";
		$list = M('goods')->field($field)->where($where)->limit($start,$num)->select();
		//var_dump($list);die;
		$c = M('goods')->field($field)->where($where)->limit($start,$num)->count();
		echo $c;
	}
	
	public function strstrtest(){
		$where = 'nbbm = ';
		if(strstr($where,'全部')){
			echo 1;
		} else {
			echo 2;
		}
	}
	
	public function testcancel() {
		$ordercode = 'wx10141471450407';
		$newstatus = $status.'O';
		$result = M('order')->where("ordercode = '{$ordercode}'")->setField('status',$newstatus);
		echo $result;
	}
	
	public function unzacc() {
		$a = '中';
		$b = mb_convert_encoding($a,'gbk','utf-8');
		$num = strlen($b);
		echo ord($b[0])+123 ."<br/>";
		echo ord($b[1])+123 ."<br/>";
		echo $num."<br/>";
		echo ord($b)+123 ."<br/>";
		echo ord($a)."<br/>";
		echo ord('A')."<br/>";
	}
	
	public function san_encrypt(){
		$body = '中国人ABC';
		$key=123;
		$gbkbody = mb_convert_encoding($body,'gbk','utf-8');
		$bodylen = strlen($gbkbody);
		//echo $bodylen;
		$enbody = '';
		for($i=0;$i<$bodylen;$i++) {
			$acc = ord($gbkbody[$i]);
			$tem = $acc + 123;
			if($enbody =='')
				$enbody = $tem;
			else
				$enbody = $enbody.'o'.$tem;
		}
		echo $enbody;
	}
	
	public function session() {
		if(empty(session('cart'))) {
			echo 1;
		} else {
			echo 2;
		}
	}
	
	public function pricestr() {
		$a = M('goods')->limit(3)->select();
		$price = $a[0]['ypdj'];
		echo doubleval($price);
		
	}
}
