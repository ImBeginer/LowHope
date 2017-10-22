<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameCT extends CI_Controller {

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

	public function createGameYN()
	{
		if(isset($_POST['end_date_time']) && isset($_POST['price_bet'])){

			try {				
				$userID = $this->session->userdata('sessionUserId');

				$end_date = $this->input->post('end_date_time');
				$end_date = date('Y-m-d H:i:s', (double)$end_date/1000);

				$price_bet = $this->input->post('price_bet');
				$start_date = date('Y-m-d H:i:s');

				if(!$this->game->checkGameYN($userID,$start_date,$end_date)){
					$this->game->createGameYN($userID,$end_date,$price_bet,$start_date);
					echo json_encode("1");					
				}else{
					echo json_encode("0");
				}

			} catch (Exception $e) {
				file_put_contents(APPPATH.'logs/lowhope.log',"\n".$e->getMessage()." IN FILE ".$e->getfile()." AT LINE :".$e->getline(),FILE_APPEND);
				echo json_encode("0");
			}

		}
	}

}

/* End of file GameCT.php */
/* Location: ./application/controllers/GameCT.php */