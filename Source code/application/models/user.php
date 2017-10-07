<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	User constants
*/
define('ROLE_ADMIN',1);
define('ROLE_MANAGER',2);
define('ROLE_USER',3);
define('FIRST_POINT',500);
define('ACTIVE',1);

class User extends CI_Model {

	public function __construct()
	{
		parent::__construct();
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
			'USER_CIF' 		=> $USER_CIF,
			'USER_NAME' 	=> $USER_NAME,
			'USER_POINT' 	=> FIRST_POINT,
			'USER_EMAIL'	=> $USER_EMAIL,
			'USER_PHONE'	=> $USER_PHONE,
			'USER_ADDRESS' 	=> $USER_ADDRESS,
			'ROLE_ID'		=> ROLE_USER,
			'ACTIVE'		=> ACTIVE
		);

		$this->db->insert('USER', $user);
		return $this->db->insert_id();
	}

	/**
	 * [checkUserExist description]
	 * @param  [type] $USER_CIF [description]
	 * @return [boolean]           [description]
	 */
	public function checkUserExist($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('USER_EMAIL', $USER_EMAIL);

		$result = $this->db->get('USER');
		$rows = $result->num_rows();

		return ($rows>0)?true:false;
	}

	/**
	 * [updateUser description]
	 * @return [type] [description]
	 */
	public function updateUser()
	{
		
	}

	public function getUserByMail($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('USER_EMAIL', $USER_EMAIL);
		$user = $this->db->get('USER');
		$user = $user->row();
		
		return $user;
	}

	public function getAllUsers()
	{
		$this->db->select('*');
		$this->db->where('ATTENDANCE', true);
		$listUsers = $this->db->get('user');
		$listUsers = $listUsers->result_array();
		return $listUsers;

	}

}

/* End of file User.php */
/* Location: ./application/models/User.php */