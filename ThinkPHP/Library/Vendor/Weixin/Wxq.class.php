<?php
namespace Vendor\Weixin;
class Wxq {
	public $errcode = 40001;
	public $errmsg = "no access";
	private $corpid = "wx53d9fb9975aa7e6f";
	private $corpsecret = "DDqbc_wS9ytDcyvUxuPqtspEot-pqXYQZtBNYQe6lqq0POgGEI5kKPYAnWZLe6je";
	private $token = '7yUuA7ltjDriCaLIhkXNCz';
	private $encodingaeskey = 'eRRydYGSjRT4eM7fGPzRnoKww2c9vwYH0bgeUWQrzOz';
	//加解密
	public $block_size = 32;
	
	/**
	* 回调验证函数
	*/
	public function valid(){
    	if($this->VerifySignature()) {
    		$echostr = urldecode($_GET['echostr']);
    		$decrypted = $this->decrypt($echostr);
    		if($decrypted) {
    			print($decrypted);
    			die;
    		} else {
    			return false;
    		}
    	} else {
    		return false;
    	}
    }
	/**
     * 根据code获取企业号登录用户的userid和微信设备号
     * @return array $json['UserId'],$json['DeviceId']
     */
    public function getUserDeviceId(){
    	$code = $_GET['code'];
    	$AccessToken = $this->getAccessToken();
    	$url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token='.$AccessToken.'&code='.$code;
    	$response = $this->http($url);
    	$json = json_decode($response,true);
    	if(isset($json['errcode'])) {
			$this->errcode = $json['errcode'];
			$this->errmsg = $json['errmsg'];
    		return false;
    	}
    	if(empty($json['OpenId'])) {
			$this->errcode = '40003';
			$this->errmsg = 'Non-business users';
			return false;
		}
		return $json;
    }

    /**
     * 获取AccessToken,并缓存7130,过期时自动重新获取缓存
     * @return 成功：string $AccessToken 失败：false,后改写成类时返回错误代码
     */
    public function getAccessToken() {
    	if(!$AccessToken = S('AccessToken')) {
    		$url = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$this->corpid.'&corpsecret='.$this->corpsecret;
    		$response = $this->http($url);
    		$arr = json_decode($response,true);
    		if(isset($arr)) return false;
    		$AccessToken = $arr['access_token'];
    		S('AccessToken',$AccessToken,7130);
    	}
    	return $AccessToken;
    }

    public function getOAuth2url($backurl,$state = 'wyorder888') {
    	$backurl = urlencode($backurl);
    	$OAuth2url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->corpid.'&redirect_uri='.$backurl.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
    	return $OAuth2url;
    }
    
    /**
     * 主动发送http请求
     * @param  string $url        请求的地址
     * @param  string $method     请求的方式(get,post,delete)
     * @param  array  $postfields 发送post数据
     * @param  array  $headers    发送的头部
     * @return [type]             请求后的响应内容
     */
    public function http( $url, $method = 'GET', array $postfields = array(), array $headers = array() ){
		$ci = curl_init();
		/* Curl settings */
		curl_setopt( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt( $ci, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ci, CURLOPT_ENCODING, 'gzip' );
		curl_setopt( $ci, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ci, CURLOPT_MAXREDIRS, 5 );
		curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ci, CURLOPT_HEADER, false );

		switch( strtoupper( $method ) )
		{
			case 'POST':
				curl_setopt( $ci, CURLOPT_POST, true );
				if ( !empty( $postfields ) )
				{
					curl_setopt( $ci, CURLOPT_POSTFIELDS, http_build_query( $postfields ) );
				}
				break;
			case 'DELETE':
				curl_setopt( $ci, CURLOPT_CUSTOMREQUEST, 'DELETE' );
				if ( !empty( $postfields ) )
				{
					$url = "{$url}?" . http_build_query( $postfields );
				}
				break;
			case 'GET':
				if ( !empty( $postfields ) )
				{
					$url = "{$url}?" . http_build_query( $postfields );
				}
				break;
		}

		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, true );

		$response = curl_exec( $ci );
		curl_close ($ci);
		return $response;
	}
	
	/**
	 * 对需要加密的明文进行填充补位
	 * @param $text 需要进行填充补位操作的明文
	 * @return 补齐明文字符串
	 */
	public function encode($text) {
		$block_size = $this->block_size;
		$text_length = strlen($text);
		//计算需要填充的位数
		$amount_to_pad = $this->block_size - ($text_length % $this->block_size);
		if ($amount_to_pad == 0) {
			$amount_to_pad = $this->block_size;
		}
		//获得补位所用的字符
		$pad_chr = chr($amount_to_pad);
		$tmp = "";
		for ($index = 0; $index < $amount_to_pad; $index++) {
			$tmp .= $pad_chr;
		}
		return $text . $tmp;
	}

	/**
	 * 对解密后的明文进行补位删除
	 * @param decrypted 解密后的明文
	 * @return 删除填充补位后的明文
	 */
	public function decode($text) {
		$pad = ord(substr($text, -1));
		if ($pad < 1 || $pad > $this->block_size) {
			$pad = 0;
		}
		return substr($text, 0, (strlen($text) - $pad));
	}

	/**
	 * 对明文进行加密
	 * @param string $text 需要加密的明文
	 * @return string 加密后的密文
	 */
	public function encrypt($text) {
		$key = base64_decode($this->encodingaeskey . "=");
		try {
			//获得16位随机字符串，填充到明文之前
			$random = $this->getRandomStr();
			$text = $random . pack("N", strlen($text)) . $text . $this->corpid;
			// 网络字节序
			$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
			$iv = substr($this->key, 0, 16);
			//使用自定义的填充方式对明文进行补位填充
			$text = $this->encode($text);
			mcrypt_generic_init($module,$key, $iv);
			//加密
			$encrypted = mcrypt_generic($module, $text);
			mcrypt_generic_deinit($module);
			mcrypt_module_close($module);

			//print(base64_encode($encrypted));
			//使用BASE64对加密后的字符串进行编码
			return base64_encode($encrypted);
		} catch (Exception $e) {
			$this->errcode = 40003;
			$this->errmsg = "encrypt function fail";
			return false;
		}
	}


	/**
	 * 对密文进行解密
	 * @param string $encrypted 需要解密的密文
	 * @return string 解密得到的明文
	 */
	public function decrypt($encrypted) {
		$key = base64_decode($this->encodingaeskey . "=");

		try {
			//使用BASE64对需要解密的字符串进行解码
			$ciphertext_dec = base64_decode($encrypted);
			$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
			$iv = substr($key, 0, 16);
			mcrypt_generic_init($module, $key, $iv);

			//解密
			$decrypted = mdecrypt_generic($module, $ciphertext_dec);
			mcrypt_generic_deinit($module);
			mcrypt_module_close($module);
		} catch (Exception $e) {
			$this->errcode = 40006;
			$this->errmsg = 'decrypt function fail';
			return false;
		}


		try {
			//去除补位字符
			$result = $this->decode($decrypted);
			//去除16位随机字符串,网络字节序和AppId
			if (strlen($result) < 16)
				return "";
			$content = substr($result, 16, strlen($result));
			$len_list = unpack("N", substr($content, 0, 4));
			$xml_len = $len_list[1];
			$xml_content = substr($content, 4, $xml_len);
			$from_corpid = substr($content, $xml_len + 4);
		} catch (Exception $e) {
			$this->errcode = 40005;
			$this->errmsg = 'decrypt function fail';
			return false;
		}
		if ($from_corpid != $this->corpid) {
			$this->errcode = 40003;
			$this->errmsg = 'decrypt function fail corpid !=corpid';
			return false;
		}
		return $xml_content;
	}

	/**
	 * 随机生成16位字符串
	 * @return string 生成的字符串
	 */
	public function getRandomStr() {
		$str = "";
		$str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($str_pol) - 1;
		for ($i = 0; $i < 16; $i++) {
			$str .= $str_pol[mt_rand(0, $max)];
		}
		return $str;
	}

}