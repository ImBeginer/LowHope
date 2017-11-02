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
			$tt_game = $this->game->getGameTT();
			$game = $this->game->getAllGameMini();
			//set sessionUserID
			$this->session->set_userdata('userGGExist', true);
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

}

/* End of file UserCT.php */
/* Location: ./application/controllers/UserCT.php */