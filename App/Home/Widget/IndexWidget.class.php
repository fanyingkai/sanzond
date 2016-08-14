<?php
namespace Home\Widget;
use Think\Controller;

class IndexWidget extends Controller {
    public function banner() {
        $banner = M('banner')->field('id,img_url')->select();
        $this->assign('banner',$banner);
        $this->display('Widget:banner');
    }
}