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
		$USER_CIF = $this->session->userdata('userData')['USER_CIF'];
		$USER_NAME = $this->input->post('USER_NAME');
		$USER_EMAIL = $this->session->userdata('userData')['USER_EMAIL'];
		$USER_PHONE = $this->input->post('USER_PHONE');
		$USER_ADDRESS = $this->input->post('USER_ADDRESS');

		//validate
		$USER_PHONE = str_replace('/[^0-9]/', '', $USER_PHONE);

		$id = $this->user->addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS);

		if($id > 0){
			//set sessionUserID
        	$this->session->set_userdata('sessionUserId', $id);
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
	public function updateUser()
	{
		$USER_ID = $this->input->post('userId');	

		if((int)$USER_ID === (int)$this->session->userdata('sessionUserId')){
			$USER_NAME = $this->input->post('username');	
			$USER_PHONE = $this->input->post('userphone');	
			$USER_ADDRESS = $this->input->post('useraddress');

			$this->user->updateUser($USER_ID,$USER_NAME,$USER_PHONE,$USER_ADDRESS);	
			echo json_encode("1");
		}else{
			echo json_encode("0");
		}
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */