<?php
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller {
	public function getenpass($str) {
		echo password($str);
	}
	
	public function getsession() {
		var_dump($_SESSION);die;
	}
}