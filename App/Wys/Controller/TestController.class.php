<?php
namespace Wys\Controller;
use Think\Controller;
use Common\Docking\Tyswx;
class TestController extends Controller {
	
	public function tyswxtest() {
		$tyswx = new Tyswx();
		$tyswx->sendmessage();
	}
}
