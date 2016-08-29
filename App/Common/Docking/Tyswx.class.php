<?php
namespace Common\Docking;

class Tyswx {
	const SAN_URL = 'http://wx.sanzond.com/wxSendInfo.aspx';
	
	/**
	 * 调用太阳升发送信息接口
	 */
	public function sendText($userid='18889562302',$msg='这是一个测试信息') {
		$enbody = $this->san_encrypt($msg);
		$data = array('UID'=>$userid,'body'=>$enbody);
		$result = http(Tyswx::SAN_URL,"post",$data);
		return $result;
	}
	
	/**
	 * 调用太阳升发送news消息接口
	 */
	public function sendNews($title,$description,$url,$picurl,$userid='18889562302') {
		$endescription = $this->san_encrypt($description);
		$entitle = $this->san_encrypt($title);
		$news = array(
			'UID'=>$userid,
			'body'=>$endescription,
			'Type'=>'News',
			'Title'=>$entitle,
			'url'=>$url,
			'PicUrl'=>$picurl,
		);
		$result = http(Tyswx::SAN_URL,"post",$news);
		return $result;
	}
	/**
	 * 太阳升加密
	 */
	public function san_encrypt($body,$key=123){
		if($body=='') return;
		$gbkbody = mb_convert_encoding($body,'gbk','utf-8');
		$bodylen = strlen($gbkbody);
		$enbody = '';
		for($i=0;$i<$bodylen;$i++) {
			$acc = ord($gbkbody[$i]);
			$tem = $acc + 123;
			if($enbody =='')
				$enbody = $tem;
			else
				$enbody = $enbody.'o'.$tem;
		}
		return $enbody;
	}
	
	public function synchronize() {
		$user = M()->db(1,'sqlsrv://soa:im123654im@112.67.32.141:8001/jxc#utf8');
		$result = $user->query('select * from zy_sys2_ypzdk');
		var_dump($result);die;
	}
}