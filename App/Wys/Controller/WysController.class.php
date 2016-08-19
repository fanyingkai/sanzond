<?php
namespace Wys\Controller;
use Think\Controller;

class WysController extends Controller {
	public function ajaxReturn($status,$info,$data) {
        $json['status'] = $status;
        $json['info'] = $info;
        $json['data'] = $data;
        parent::ajaxReturn($json);
    }
}