<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
	}

	/**
	 * [addUser description]
	 */
	public function addUser()
	{
		$USER_CIF = $this->input->post('USER_CIF');
		$USER_NAME = $this->input->post('USER_NAME');
		$USER_EMAIL = $this->input->post('USER_EMAIL');
		$USER_PHONE = $this->input->post('USER_PHONE');
		$USER_ADDRESS = $this->input->post('USER_ADDRESS');

		//validate
		$USER_CIF = str_replace('/[^0-9]/', '', $USER_CIF);
		$USER_PHONE = str_replace('/[^0-9]/', '', $USER_PHONE);

		$id = $this->user->addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS);

		if($id > 0){
			$data['USER_NAME'] = $USER_NAME;
			$this->load->view('user/home', $data);
		}else {
			$this->load->view('errors/error_page');
		}
	}

	/**
	 * [updateUser description]
	 * @param  [type] $USER_CIF [description]
	 * @return [type]           [description]
	 */
	public function updateUser($USER_CIF)
	{
		
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */