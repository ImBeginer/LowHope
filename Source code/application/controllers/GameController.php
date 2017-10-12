<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$this->load->model('game');
	}

	/**
	 * [add_Ans_Game_TT description]
	 */
	public function add_Ans_Game_TT()
	{	
		//TODO kiểm tra price > 0 ?
		
		$checksessionUserId = $this->session->userdata('sessionUserId');
		
		if(isset($checksessionUserId)){

			$user = $this->user->getUserById($this->session->userdata('sessionUserId'));
			$USER_POINT = $user->USER_POINT;
			$PRICE = $this->input->post('price_bet');	

			if($USER_POINT >= $PRICE){

				$GAME_TT_ID = $this->session->userdata('session_Game_TT_ID');
				$USER_ID = $this->session->userdata('sessionUserId');
				// $PRICE = $this->input->post('price_bet');
				$DATE = date("Y-m-d H:i:s");

				$check_His_User = $this->game->check_His_User($USER_ID, $GAME_TT_ID);
				if($check_His_User){
					$check = $this->game->updateBetUser($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
					if($check){
						echo json_encode("1");
					}else{
						echo json_encode("0");
					}
				}else{
					$check = $this->game->addBetUser($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
					if($check){
						echo json_encode("1");
					}else{
						echo json_encode("0");
					}
				} 
			}else {
				echo json_encode("2");
			}

		}
	}

}

/* End of file GameController.php */
/* Location: ./application/controllers/GameController.php */