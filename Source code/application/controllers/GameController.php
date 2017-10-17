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

	/********************************* GAME TRUYEN THONG ***********************************************/

	/**
	 * [log_game_tt description]
	 * @return [type] [description]
	 */
	public function log_game_tt()
	{	
		//TODO kiểm tra price > 0 ?
		
		$checksessionUserId = $this->session->userdata('sessionUserId');
		
		if(isset($checksessionUserId)){

			$PRICE = $this->input->post('price_bet');	

			if($PRICE && (double)$PRICE > 0){

				$GAME_TT_ID = $this->session->userdata('session_Game_TT_ID');
				$USER_ID = $this->session->userdata('sessionUserId');
				$DATE = date("Y-m-d H:i:s");

				$check_Log_Game_TT = $this->game->check_Log_Game_TT($USER_ID, $GAME_TT_ID);
				if($check_Log_Game_TT){
					$check = $this->game->update_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
					if($check){
						echo json_encode("1");
					}else{
						echo json_encode("0");
					}
				}else{
					$check = $this->game->add_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
					if($check){
						echo json_encode("1");
					}else{
						echo json_encode("0");
					}
				} 
			}else {
				echo json_encode("2");
			}
		}else{
			//TODO
			echo json_encode("0");
		}
	}

}

/* End of file GameController.php */
/* Location: ./application/controllers/GameController.php */