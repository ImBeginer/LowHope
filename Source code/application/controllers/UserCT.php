<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCT extends CI_Controller {
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$this->load->model('game');
	}

	/**
	 * [addUser description]
	 */
	public function home()
	{		
		try {
    		$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);

    		if($user->ROLE_ID == ROLE_USER){
				$tt_game = $this->game->getGameTT();
				$game = $this->game->getAllGameMiniActive();
				//set sessionUserID
		    	$this->session->set_userdata('sessionUserId', $user->USER_ID);
			    $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

				$data['USER_NAME'] = $user->USER_NAME;
				$data['USER_POINT'] = $user->USER_POINT;
		        $data['GAME_TT_CONTENT'] = $tt_game->CONTENT;
		        $data['TT_END_DATE'] = $tt_game->END_DATE;

		        //$data['prices'] = $this->user->getData();
		        if(isset($game['YN'])){
	                $data['YN'] = $game['YN'];                            
	            }else{
	                $data['YN'] = array(); 
	            }

	            if(isset($game['MUL'])){
	                $data['MUL'] = $game['MUL'];                            
	            }else{
	                $data['MUL'] = array();
	            }

				$this->load->view('user/home', $data);		
    		}else{
    			redirect(base_url());
    		}
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
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
		$USER_ID = $this->session->userdata('sessionUserId');	

		if(isset($USER_ID)){
			$USER_NAME = $this->input->post('username');	
			$USER_PHONE = $this->input->post('userphone');	
			$USER_ADDRESS = $this->input->post('useraddress');

			$this->user->updateUser($USER_ID,$USER_NAME,$USER_PHONE,$USER_ADDRESS);	
			echo json_encode("1");
		}else{
			echo json_encode("0");
		}
	}

	/**
	 * [history description]
	 * @return [type] [description]
	 */
	public function history()
	{
		$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
		$data['USER_NAME'] = $user->USER_NAME;
        $data['USER_POINT'] = $user->USER_POINT;
		$this->load->view('user/history', $data);
	}

	/**
	 * [checkUserExist description] Kiểm tra email có tồn tại không
	 * @return [type] [description]
	 */
	public function checkUserExist()
	{
		if(isset($_POST['email']) && isset($_POST['pass'])){
			$email = $this->input->post('email');
			$pass = $this->input->post('pass');
			$isExist = $this->user->checkUserExist($email);
			if($isExist){
				//email tồn tại, kiểm tra xem pass có đúng không
				$user = $this->user->getUserByMail($email);
				if($pass === $user->PASSWORD){
					$userData['USER_EMAIL'] = $email;
					$userData['USER_AVATAR'] = null;
					//set session
					$this->session->set_userdata('userData', $userData);
					$this->session->set_userdata('loggedOther', true);
					
					//email, pass trung khop
					echo json_encode(2);
				}else{
					echo json_encode(0);
				}
			}else{
				//email chưa có => add user
				echo json_encode(1);
			}
		}
	}

	/**
	 * [add_other_user description]add user using passworld
	 * @param string $value [description]
	 */
	public function add_other_user()
	{
		if(isset($_POST['email']) && isset($_POST['pass'])){
			//add vao csdl xong lay id ra lam ten
			
			$email = $this->input->post('email');
			$pass = $this->input->post('pass');
			$created_date = date("Y-m-d");

			$id = $this->user->add_other_user($email, $pass, $created_date);
			if($id > 0){
				$userData['USER_EMAIL'] = $email;
				$userData['USER_AVATAR'] = null;
				//set session
				$this->session->set_userdata('userData', $userData);
				$this->session->set_userdata('loggedOther', true);
				
				echo json_encode(1);	 
			}else{
				echo json_encode(0);
			}
		}
	}

	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout()
	{
		//delete login status & user info from session
        $this->session->set_userdata('loggedOther', false);
        $this->session->unset_userdata('loggedOther');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('sessionUserId');
        $this->session->sess_destroy();        
        
        redirect(base_url().'login');
	}

}

/* End of file UserCT.php */
/* Location: ./application/controllers/UserCT.php */