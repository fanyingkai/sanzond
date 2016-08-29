<?php
namespace Admin\Controller;

class GoodsController extends ContentController{
	public function save() {
		if(IS_POST) {
			$goods = M('goods');
			if($goods->create()) {
				if($goods->save()) {
					$this->success('修改药品信息成功');
				} else {
					$this->error('修改信息失败！');
				}
			}
		}
		return;
	}
}