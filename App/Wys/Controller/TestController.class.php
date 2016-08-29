<?php
namespace Wys\Controller;
use Think\Controller;
use Common\Docking\Tyswx;
class TestController extends Controller {
	
	public function tyswxtest() {
		$tyswx = new Tyswx();
		$tyswx->sendmessage();
	}
	
	public function getkey($str) {
		
	}
	
	public function synchronize() {
		$ypzdk = M('ypzdk','zy_sys2_','sqlsrv://soa:im123654im@112.67.32.141:8001/jxc#utf8');
		$num = $ypzdk->count();
		if(empty($result)) {
			echo $result->geterror();
		} else {
			var_dump($result);
		}
	}
	
	public function testinc() {
		M('order')->where('1=1')->setField('downnum',0);
	}
}
