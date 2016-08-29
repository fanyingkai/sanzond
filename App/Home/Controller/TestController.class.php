<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	
	public function clear() {
		session(null);
	}
	
	public function getsession() {
		var_dump($_SESSION);die;
		echo getuserid();
		echo getuid();
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
	
	public function getconfig() {
		$num = D('config')->getconfig('pagenum');
		echo $num;
	}
	
	public function geturl() {
		$weobj = new \Vendor\Weixin\Wxq();
		$backurl = "sanzond.hnsichuang.com/Home/Auth/login";
		echo $weobj->getOAuth2url($backurl);
	}
	
	public function geturlorder() {
		$weobj = new \Vendor\Weixin\Wxq();
		$backurl = "jf.sanzond.com/Home/Test/wxtest";
		return $weobj->getOAuth2url($backurl);
	}
	
	public function testlogin() {
		if(!session('?userid')) {
            $this->redirect('Auth/login');
        }
	}
	
	public function getserver() {
		var_dump($_SERVER);die;
	}
	
	public function chose() {
		$arr = explode('.',$_SERVER['HTTP_HOST']);
		echo $arr[0].'db';
	}
	
	public function getgoods() {
		$a = M('sangoods')->limit(10)->select();
		echo $a[1]['thumbnails'];
		if(isset($a[1]['thumbnails'])) {
			echo 1;
		} else {
			echo 2;
		}
		if(isset($a[0]['thumbnails'])) {
			echo $a[0]['thumbnails'];
		} else {
			echo 2;
		}
	}
	
	public function sendnews() {
		$tys = new \Common\Docking\Tyswx();
		$url = $this->geturlorder();
		$result = $tys->sendNews('测试信息','你好啊！',$url,'');
		echo $result;
	}
	
	public function wxtest() {
		/* 测试WX回调能否正常接收
		*/
		$state = I('state');
		$wxqobj = new WxqController();
		$userinfo = $wxqobj->getUserDeviceId();
        $userid = $userinfo['UserId'];
		echo $state;
		echo "<br/>".$userid.'111';
	}
	
	public function showerror() {
		$this->error('失败');
	}
	
	public function showsuccess() {
		$this->success('成功');
	}
	
	public function showsucc() {
		echo C('TMPL_ACTION_SUCCESS');
		echo C('TMPL_ACTION_ERROR');
	}
}
