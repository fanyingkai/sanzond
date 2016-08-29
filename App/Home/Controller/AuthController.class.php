<?php
namespace Home\Controller;
use Think\Controller;

class AuthController extends Controller {
    public function login() {
		$wxqobj = new WxqController();
		$userinfo = $wxqobj->getUserDeviceId();
        $userid = $userinfo['UserId'];
		//匿名用户登录
		if(empty($userid)) {
			if(chosedb()=='testdb') {
				$userid = 1;
				$uid = 1;
			} else {
				header("Location: http://test.sanzond.com");
				exit;
			}
		} else {
			$uidm = M('sanuser')->where("userid = '{$userid}'")->field('id')->find();
			if(empty($uidm)) {
				writelog('前台登陆','系统记录',"{$userid}用户请求被拒绝，原因:系统中用户无相关记录");
				$this->error('非企业用户，禁止访问！为您转入测试系统',"http://test.sanzond.com");
			} else {
				$uid = $uidm['id'];
			}
		}
        session('userid',base64_encode($userid));
		session('uid',base64_encode($uid));
		writelog('前台登陆','系统记录',"{$userid}用户登录成功！");
        $this->redirect('Index/index');
    }
	
	/**
	 * 认证用户并判断用户是否可以查看订单，如可行，则跳转至对应订单详情页
	 */
	public function authorder() {
		$wxqobj = new WxqController();
		$userinfo = $wxqobj->getUserDeviceId();
		$userid = $userinfo['UserId'];
		$ordercode = I('state','');
		if($ordercode=='') {
			echo "参数错误";die;
		}
		if(getuserid()==$userid) {
			$this->redirect('Order/detail',array('ordercode'=>$ordercode));
		} else {
			$uidm = M('sanuser')->where("userid = '{$userid}'")->field('id')->find();
			if(empty($uidm)) {
				writelog('前台登陆','系统记录',"{$userid}用户请求被拒绝，原因:系统中用户无相关记录");
				$this->error('非企业用户，禁止访问！为您转入测试系统',"http://test.sanzond.com");
			} else {
				$uid = $uidm['id'];
			}
			session('userid',base64_encode($userid));
			session('uid',base64_encode($uid));
			writelog('News消息回调登录','系统记录',"{$userid}用户登录成功！");
			$this->redirect('Order/detail',array('ordercode'=>$ordercode));
		}
	}
}