<?php
namespace Home\Widget;
use Think\Controller;

class PayWidget extends Controller {
    
    /*
     * 渲染微信公众号内支付所需要的数据
     * @参数:
     */
    public function wxpay($orderinfo) {
        vendor('Weixin.Pay.JSAPI');
        $tools = new \JsApiPay();
        $openId = session('openid');
        $Out_trade_no=$orderinfo['ordercode'];
        $Body='订单编号'.$Out_trade_no;
        $Total_fee=doubleval($orderinfo['totalprice']) * 100;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($Body);
        $input->SetOut_trade_no($Out_trade_no);
        $input->SetTotal_fee($Total_fee);
        $input->SetNotify_url("http://wesnack.syerx.com/pay/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $this->jsApiParameters = $tools->GetJsApiParameters($order);
        $success_url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $this->assign('successurl',$success_url);
        $this->display();
    }
}
