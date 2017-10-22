<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();		
	}
	
	/**
	 * [checkUserExist description]
	 * @param  [type] $EMAIL [description]
	 * @return [type]        [description]
	 */
	public function checkUserExist($EMAIL)
	{
		$this->db->select('*');
		$this->db->where('EMAIL', $EMAIL);
		
		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;			
		}else{
			throw new Exception('Error from checkUserExist()');
		}
	}

	/**
	 * [checkUserExistPlus description]
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function checkUserExistPlus($USER_CIF,$USER_EMAIL)
	{
		$condi = array('USER_CIF'=>$USER_CIF, 'EMAIL'=>$USER_EMAIL);
		$this->db->where($condi);
		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from checkUserExistPlus()');
		}
	}

	/**
	 * [addUser description]
	 * @param [string] $USER_CIF     [mã số google or facebook của user]
	 * @param [string] $USER_NAME    [description]
	 * @param [string] $USER_EMAIL   [description]
	 * @param [string] $USER_PHONE   [description]
	 * @param [string] $USER_ADDRESS [description]
	 */
	public function addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS)
	{
		$user = array(
			'ROLE_ID'		=> ROLE_USER,
			'USER_CIF' 		=> $USER_CIF,
			'USER_NAME' 	=> $USER_NAME,
			'USER_POINT' 	=> 500,
			'EMAIL'			=> $USER_EMAIL,
			'PHONE_NUMBER'	=> $USER_PHONE,
			'ADDRESS' 		=> $USER_ADDRESS,
			'ATTENDANCE'	=> 1,
			'ACTIVE'		=> 1
		);

		if($this->db->insert('USERS', $user)){
			return $this->db->insert_id();			
		}else{
			throw new Exception('Error from addUser()');
		}
	}

	/**
	 * [getUserByMail description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function getUserByMail($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('EMAIL', $USER_EMAIL);
		$user = $this->db->get('USERS');
		if($user){
			$user = $user->row();			
			return $user;
		}else{
			throw new Exception('Error from getUserByMail()');
		}
	}

	/**
	 * [getUserById description]
	 * @param  [type] $USER_ID [description]
	 * @return [type]          [description]
	 */
	public function getUserById($USER_ID)
	{
		$this->db->select('*');
		$this->db->where('USER_ID', $USER_ID);
		$user = $this->db->get('USER');
		$user = $user->row();
		
		return $user;
	}

	/**
	 * [updateUser description]     google + facebook
	 * @param  [type] $USER_ID      [description]
	 * @param  [type] $USER_NAME    [description]
	 * @param  [type] $USER_PHONE   [description]
	 * @param  [type] $USER_ADDRESS [description]
	 * @return [type]               [description]
	 */
	public function updateUser($USER_ID,$USER_NAME,$USER_PHONE,$USER_ADDRESS)
	{
		$user = array(
			'USER_NAME' => $USER_NAME,
			'PHONE_NUMBER' => $USER_PHONE,
			'ADDRESS' => $USER_ADDRESS
		);

		$this->db->where('USER_ID', $USER_ID);
		$this->db->update('USERS', $user);
	}

	/**
	 * [checkFBUserChanged description]
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function checkFBUserChanged($USER_CIF)
	{
		$condi = array('USER_CIF' => $USER_CIF);
		$this->db->select('*');
		$this->db->where($condi);

		$result = $this->db->get('USERS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from checkFBUserChanged()');
		}

	}

	/**
	 * [updateFBUser description] when informations of user was changed
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_NAME  [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function updateFBUser($USER_CIF,$USER_NAME,$USER_EMAIL)
	{
		$user = array(
			'USER_NAME' => $USER_NAME,
			'EMAIL' => $USER_EMAIL
		);

		$this->db->where('USER_CIF', $USER_CIF);
		if(!$this->db->update('USERS', $user)){
			throw new Exception('Error from updateFBUser()');
		}
	}
}

/* End of file User.php */
/* Location: ./application/models/User.php */