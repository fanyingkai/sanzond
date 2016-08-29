<?php
namespace Home\Logic;

class SanuserLogic extends BaseLogic {
	/**
	 * 得到用户详细信息
	 */
	public function getuserinfo() {
		$userid = getuserid();
		$where = array('userid'=>$userid);
		$info = $this->where($where)->find();
		return $info;
	}
	
	public function getcompany($companyname) {
		$where = array('name'=>$companyname);
		$field = 'id';
		$info = M('company')->field($field)->where($where)->find();
		return $info;
	} 
	
	/**
	* 得到用户联系信息
	*/
	public function getUsercontact() {
		$model = M('user_contacts');
		$userid = getuserid();
		$where = "userid = '{$userid}'";
		$usercontactlist = $model->field('id,name,phone,address')->where($where)->select();
		if(!empty($usercontactlist)) {
			return $usercontactlist;
		} else {
			$field = 'cname,name';
			$userinfo = M('sanuser')->field()->where($where)->find();
			$m = M('company');
			$companyinfo = $m->field('contacts as name,address')->where("name='{$userinfo['cname']}'")->select();
			return $companyinfo;	
		}
	}
	
	public function getUsercontactc() {
		$model = M('user_contacts');
		$userid = getuserid();
		$where = "userid = '{$userid}'";
		$usercontactlist = $model->field('id,name,phone,address')->where($where)->select();
		return $usercontactlist;
	}
	
	/*
	*	创建收货人信息
	*/
	public function createAddress($data) {
		$model = M('user_contacts'); 
		$data['userid'] = getuserid();
		$status = $model->add($data);
		if($status)
			return true;
		else 
			return false;		
	}
	
	/**
	*	删除送货信息
	*  参数：送货地址id
	*/
	public function deleteAddress($id){
		$model = M('user_contacts'); 
		$status = $model->delete($id);
		if($status){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	*	门店信息编辑页面跳转
	*	参数：送货地址id
	*/
	public function editAddressJump($id){
		$model = M('user_contacts'); 
		$where="id = '{$id}'";
		$address = $model->where($where)->find();
		if($address){
			return $address;
		}else{
			return false;
		}
		
	}
	
	/**
	* 编辑送货信息
	* 参数：送货地址id
	*/
	
	public function editAddress($id){
		$model = M('user_contacts');
		$where="id = '{$id}'";
		$status = $model->where($where)->save($_POST);
		if($status){
			return true;
		}else {
			return false;
		}
		
	}
	
}