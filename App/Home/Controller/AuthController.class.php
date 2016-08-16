<?php
namespace Home\Controller;
use Think\Controller;

class AuthController extends Controller {
    public function login() {
        $userid = 1;
        session('userid',base64_encode($userid));
        $this->redirect('Index/index');
    }    
} 