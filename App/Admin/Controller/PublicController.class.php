<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class PublicController extends Controller {
    public function login(){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if(empty($username)) $this->error('账号或密码有误');
        $Model = M('User');
        //判断用户输入的用户类型
        if(preg_match('/^1[34578]{1}\d{9}$/',$username)) {
            $where = array('phone'=>$username ,'password'=> password($password),);
        } elseif(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $username)) {
            $where = array('email'=>$username,'password'=>password($password));
        } else {
            $where = array('username'=>$username,'password'=>password($password));
        }
        //对比数据库中用户信息
        $user  = $Model->where($where)->find();
        if(!$user) $this->error('账号或密码有误');
        if($user['is_active']==0) $this->error('用户状态异常，请联系管理员');
        //保存信息
        $usersession = array(
            'uid'         =>$user['id'],
            'gid'       =>$user['gid'],
            'username'  =>$user['username'],
        );
        $Model->where(array('id'=>$usersession['uid']))->setField('date_update',date("Y-m-d H:i:s",time()));
        session('user',$usersession);
        //记录日志
        recordlog('登录后台系统','系统操作');
        header('location:'.U('Index/index'));
    }
    
    public function logout(){
        recordlog('注销后台系统','系统操作');
		session('user',null);
		$this->success('注销用户成功！',U('Public/loginx'));
	}
	
    public function upload($type="") {
        //路径更换为内容模型名称
        switch ($type) {
            case 'A':
                $url = 'Article/';
                break;
            case 'H':
                $url = 'House/';
                break;
            case 'B':
                $url = 'Banner/';
                break;
            case 'CWS':
                $url = 'Cws/';
                break;
            default:
                break;
        }
        $config = array(
            'maxSize'=>3145728,
            'exts'=>array('jpg','gif','png','jpeg'),
            'savePath'=>$url,
        );
        $upload = new Upload($config);
        $info = $upload->upload();
        if($info) {
            $info = reset($info);
            $file['fileurl']=$info['savepath'].$info['savename'];
            $json['url'] = $file['fileurl'];
            $this->ajaxReturn($json);
        } else {
            $this->error($upload->getError());//获取失败信息
        }
    }
}