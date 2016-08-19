<?php
namespace Home\Widget;
use Think\Controller;

class GallWidget extends Controller {
    /**
     * 幻灯片
     */
    public function banner() {
        //$banner = M('banner')->field('id,img_url')->select();
        //$this->assign('banner',$banner);
        $this->display('Widget:banner');
    }
    
    /**
     * 购物车底部
     */
    public function cartbuttom() {
        $this->display('Widget:cartbuttom');
    }
	
	public function topsearch() {
		$this->display('Widget:search');
	}
}