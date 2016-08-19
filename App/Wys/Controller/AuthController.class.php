<?php
namespace Wys\Controller;
use Think\Controller;

class AuthController extends Controller {
    public function login() {
        $userid = 1;
		$uid = 1014;
        session('userid',base64_encode($userid));
		session('uid',base64_encode($uid));
        $this->redirect('Index/index');
    }    
} 