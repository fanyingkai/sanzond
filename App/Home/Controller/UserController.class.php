<?php
namespace Home\Controller;

class UserController extends ContentController {
	/**
	 * 用户界面首页
	 */
	public function index() {
		$model = D('sanuser','Logic');
		$userinfo = $model->getuserinfo();
		$contacts = $model->getUsercontact();
		$cname = $userinfo['cname'];
		$this->assign('cname',$cname);
		$this->assign('contacts',$contacts);
		$this->display('Content/stores');
	}
	
	/**
	* 用户界面添加送货信息
	*/
	public function addAddress() {
		$this->display('Content/addAddress');
		
	}
	
	/**
	* 创建送货信息
	*/
	public function createAddress() {
		if($_POST['name']=='') $this->error('联系人不能为空');
		if($_POST['address']=='') $this->error('地址不能为空');
		if($_POST['phone']=='') $this->error('手机号不能为空');
		$model = D('user','Logic');
		$addAddress = $model->createAddress($_POST);
		if($addAddress){
			$this->success('添加成功',U('User/index'));
		}else {
			$this->error('添加失败',U('User/index'));
		}
	}
	
	/**
	* 删除送货信息
	* 参数：送货地址id
	*/
	public function deleteAddress($id){
		$id = urldecode($id);
		$model = D('sanuser','Logic');
		$status = $model->deleteAddress($id);
		if($status){
			$this->success('删除成功',U('User/index'));
		}else {
			$this->error('删除失败',U('User/index'));
		}
	}
	
	/**
	*	门店信息编辑页面跳转
	*	参数：送货地址id
	*/
	public function editAddressJump($id){
		$id = urldecode($id);
		$model = D('sanuser','Logic');
		$address = $model->editAddressJump($id);
		if($address){
			$this->assign('address',$address);
			$this->display('Content/editAddress');
		}else{
			$this->error('请求失败',U('User/index'));
		}
	}
	
	/**
	* 编辑送货信息
	* 参数：送货地址id
	*/
	
	public function editAddress($id){
		$id = urldecode($id);
		$model = D('sanuser','Logic');
		$status = $model->editAddress($id);
		if($status){
			$this->success('编辑成功',U('User/index'));
		}else {
			$this->error('编辑失败',U('User/editAddressJump'));
		}
		
	}
}