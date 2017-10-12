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
	 * [getUserByMail description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function getUserByMail($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('USER_EMAIL', $USER_EMAIL);
		$user = $this->db->get('USER');
		$user = $user->row();
		
		return $user;
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
			'USER_PHONE' => $USER_PHONE,
			'USER_ADDRESS' => $USER_ADDRESS
		);

		$this->db->where('USER_ID', $USER_ID);
		$this->db->update('USER', $user);
	}

	/**
	 * [checkUserExist description]
	 * @param  [type] $USER_CIF [description]
	 * @return [boolean]           [description]
	 */
	public function checkGGUserExist($USER_EMAIL)
	{
		$this->db->select('*');
		$this->db->where('USER_EMAIL', $USER_EMAIL);

		$result = $this->db->get('USER');
		$rows = $result->num_rows();

		return ($rows>0)?true:false;
	}

	public function checkUserFBExist($USER_CIF)
	{
		$this->db->select('*');
		$this->db->where('USER_CIF', $USER_CIF);

		$result = $this->db->get('USER');
		$rows = $result->num_rows();

		return ($rows>0)?true:false;
	}

	/**
	 * [checkFBUserChanged description]
	 * @param  [type] $USER_CIF   [description]
	 * @param  [type] $USER_EMAIL [description]
	 * @return [type]             [description]
	 */
	public function checkFBUserChanged($USER_CIF,$USER_EMAIL)
	{
		$condi = array('USER_CIF' => $USER_CIF, 'USER_EMAIL' => $USER_EMAIL);
		$this->db->select('*');
		$this->db->where($condi);

		$result = $this->db->get('USER');
		$rows = $result->num_rows();

		return ($rows>0)?false:true;
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
			'USER_EMAIL' => $USER_EMAIL
		);

		$this->db->where('USER_CIF', $USER_CIF);
		$this->db->update('USER', $user);
	}

	

	//demo highchart
	public function getData()
	{
		$this->db->select('DATA_PRICE, DATA_DATE');
		//$this->db->order_by('DATA_DATE');
		$result = $this->db->get('DATA');
		$result = $result->result_array();

		return json_encode($result);
	}

}

/* End of file User.php */
/* Location: ./application/models/User.php */