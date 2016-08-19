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
		echo $result;
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
}