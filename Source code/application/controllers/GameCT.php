<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once 'Common.php';

class GameCT extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$this->load->model('game');
	}

	public function goHome()
	{
		if ($this->session->userdata('loggedInGooge')) {
			redirect(base_url().'login/user','refresh');
		}else if($this->session->userdata('loggedInFB')){
			redirect(base_url().'login/fb_goHome','refresh');
		}
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

	/**
	 * [createGameYN description]
	 * @return [type] [description]
	 */
	public function createGameYN()
	{
		if(isset($_POST['game_title']) && isset($_POST['end_date_time']) && isset($_POST['price_bet'])){

			try {				
				$userID = $this->session->userdata('sessionUserId');

				//check tai khoan co du tien tao game khong
				if($this->user->canCreateGame($userID)){

					$user = $this->user->getUserById($userID);
					$user_point = $user->USER_POINT;

					$game_title = $this->input->post('game_title');

					$end_date = $this->input->post('end_date_time');
					$end_date = date('Y-m-d H:i:s', (double)$end_date/1000);

					$price_bet = $this->input->post('price_bet');
					$start_date = date('Y-m-d H:i:s');

					if(!$this->game->checkGameYN($userID, $start_date, $end_date)){
						$this->game->createGameYN($userID, $game_title, $end_date, $price_bet, $start_date);

						$user_point = $user_point - 50;
						$this->user->updatePoint($userID,$user_point);

						$userNew = $this->user->getUserById($userID);
						echo json_encode(array('create'=>1, 'user_point'=>$userNew->USER_POINT));					
					}else{
						echo json_encode(array('create'=>0));
					}
				}else{
					echo json_encode(array('create'=>2));
				}
			} catch (Exception $e) {
				file_put_contents(APPPATH.'logs/lowhope.log',"\n".$e->getMessage()." IN FILE ".$e->getfile()." AT LINE :".$e->getline(), FILE_APPEND);
				echo json_encode("0");
			}

		}
	}


	public function createGameMulti()
	{
		if(isset($_POST['game_title_mul']) && isset($_POST['end_date_time']) && isset($_POST['price_below']) && isset($_POST['price_above'])){
			try {
				$userID = $this->session->userdata('sessionUserId');

				if($this->user->canCreateGame($userID)){
					$user = $this->user->getUserById($userID);
					$user_point = $user->USER_POINT;

					$game_title = $this->input->post('game_title_mul');
					$start_date = date('Y-m-d H:i:s');

					$end_date = $this->input->post('end_date_time');
					$end_date = date('Y-m-d H:i:s', (double)$end_date/1000);

					$price_below = $this->input->post('price_below');
					$price_above = $this->input->post('price_above');

					if(!$this->game->checkGameMulti($userID,$start_date,$end_date)){
						$this->game->createGameMulti($userID,$game_title,$start_date,$end_date,$price_below,$price_above);

						$user_point = $user_point - 50;
						$this->user->updatePoint($userID,$user_point);

						$userNew = $this->user->getUserById($userID);
						echo json_encode(array('create'=>1, 'user_point'=>$userNew->USER_POINT));
					}else{
						echo json_encode(array('create'=>0));
					}
				}else{
					echo json_encode(array('create'=>2));
				}
			} catch (Exception $e) {
				file_put_contents(APPPATH.'logs/lowhope.log',"\n".$e->getMessage()." IN FILE ".$e->getfile()." AT LINE :".$e->getline(), FILE_APPEND);
				echo json_encode("0");
			}
		}
	}

	
	public function yn()
	{		
		$game_id = (int)$this->uri->segment(3);
		if($game_id > 0){
			//get data from table game yes no
			$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
			if($user){
				$game = $this->game->getAllGameMini();

				$data['USER_NAME'] = $user->USER_NAME;
	            $data['USER_POINT'] = $user->USER_POINT;

	            //$data['prices'] = $this->user->getData();
	            $data['YN'] = $game['YN'];
	            $data['MUL'] = $game['MUL'];
				$data['game_data'] = $this->game->getGameYN_ById($game_id);


							
				$this->load->view('game/gameYN', $data);				
			}else{
				$this->goHome();
			}
		}else{			
			$this->goHome();
		}		
	}

	public function log_game_yes_no()
	{
		//kiểm tra xem user có điều kiện tham gia game hay không?
		//TODO
		
		$userID = $this->session->userdata('sessionUserId');
		if(isset($_POST['game_id']) && isset($_POST['answer'])){

			$gameID =$this->input->post('game_id');

			//kiểm tra xem user đã đặt cược game này chưa
			if(!$this->game->is_log_game($userID,$gameID,1)){
				$answer = $this->input->post('answer');
				$ans_time = date('Y-m-d H:i:s');

				$result = $this->game->log_game_yes_no($userID,$gameID,$answer,$ans_time);
				if($result > 0){
					echo json_encode(1);
				}else{
					echo json_encode(0);
				}
			}else{
				echo json_encode(2);
			}
			
		}

	}

	public function mul()
	{
		$game_id = (int)$this->uri->segment(3);
		if($game_id > 0){
			//get data from table game yes no
			$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
			if($user){
				$game = $this->game->getAllGameMini();

				$data['USER_NAME'] = $user->USER_NAME;
	            $data['USER_POINT'] = $user->USER_POINT;

	            //$data['prices'] = $this->user->getData();
	            $data['YN'] = $game['YN'];
	            $data['MUL'] = $game['MUL'];

				$data['game_data'] = $this->game->getGameMUL_ById($game_id);

				$this->load->view('game/gameMUL', $data);				
			}else{
				$this->goHome();
			}
		}else{			
			$this->goHome();
		}	
	}

}

/* End of file GameCT.php */
/* Location: ./application/controllers/GameCT.php */