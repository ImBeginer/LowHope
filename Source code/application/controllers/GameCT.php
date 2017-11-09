<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class GameCT extends CI_Controller {
	public $pusher;
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$this->load->model('game');

		$options = array(
			'cluster' => 'ap1',
			'encrypted' => true
		);
		$this->pusher = new Pusher\Pusher(
			'711b956416d9d15de4b8',
			'806a478e4cde60531b0a',
			'409599',
			$options
		);
	}

	/**
	 * [goHome description]
	 * @return [type] [description]
	 */
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

	/********************************* GAME YES NO ***********************************************/

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
						$gameID = $this->game->createGameYN($userID, $game_title, $end_date, $price_bet, $start_date);
						$game = $this->game->getGameYN_ById($gameID);

						$user_point = $user_point - FEE_CREATE;
						$this->user->updatePoint($userID,$user_point);

						$userNew = $this->user->getUserById($userID);


						//call pusher để update item slide
						$data['gameID'] = $gameID;
						$data['game_title'] = $game_title;
						$data['user_create'] = $user->USER_NAME;
						$data['total_amount'] = $game->TOTAL_AMOUNT;
						$this->pusher->trigger('create_game_yes_no_channel', 'create_game_yes_no_event', $data);

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

	/**
	 * [yn description]
	 * @return [type] [description]
	 */
	public function yn()
	{		
		$game_id = (int)$this->uri->segment(3);
		if($game_id > 0){
			//get data from table game yes no
			$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
			if($user){

				$data['USER_NAME'] = $user->USER_NAME;
	            $data['USER_POINT'] = $user->USER_POINT;

	            //$data['prices'] = $this->user->getData();
				$game = $this->game->getAllGameMiniActive();

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

				$data['game_data'] = $this->game->getGameYN_ById($game_id);

				// Lấy danh sách lịch sử log của game này
				$log_game = $this->game->get_Log_Game_By_Id($game_id,GAME_YN);
				
				if($log_game){					
					$data['list_bet_log'] = $log_game;
				}

				if($data['game_data']){
					//lay ti le phan tram nguoi choi da tra loi
					$ans = $this->game->getRatioYN($game_id);
					
					$data['ans_yes'] = $ans['YES'];
					$data['ans_no'] = $ans['NO'];

					// $this->load->view('layout/header');
					$this->load->view('game/gameYN', $data);				
					// $this->load->view('layout/footer');
				}else{
					$this->goHome();
				}

			}else{
				
				//GEST view
				$game = $this->game->getAllGameMiniActive();

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


				// Lấy danh sách lịch sử log của game này
				$log_game = $this->game->get_Log_Game_By_Id($game_id,GAME_YN);
				
				if($log_game){					
					$data['list_bet_log'] = $log_game;
				}

				$data['game_data'] = $this->game->getGameYN_ById($game_id);

				if($data['game_data']){
					//lay ti le phan tram nguoi choi da tra loi
					$ans = $this->game->getRatioYN($game_id);
					
					$data['ans_yes'] = $ans['YES'];
					$data['ans_no'] = $ans['NO'];

					// $this->load->view('layout/header');
					$this->load->view('game/gameYN', $data);				
					// $this->load->view('layout/footer');
				}else{
					redirect(base_url());
				}
			}
		}else{			
			$this->goHome();
		}		
	}

	/**
	 * [log_game_yes_no description]
	 * @return [type] [description]
	 */
	public function log_game_yes_no()
	{	
		if(isset($_POST['game_id']) && isset($_POST['answer'])){
			$userID = $this->session->userdata('sessionUserId');
			$gameID =$this->input->post('game_id');

			//kiểm tra xem game đã full người chơi chưa
			if(!$this->game->isFull($gameID,GAME_YN)){
				// Kiểm tra xem người chơi có phải là người tạo ra game này hay không
				if(!$this->user->isOwnerGame($userID,$gameID,GAME_YN)){
					// Kiểm tra xem có đủ tiền chơi hay không?
					if($this->user->canPlayGame($userID)){
						//kiểm tra xem user đã đặt cược game này chưa
						if(!$this->game->is_log_game($userID,$gameID,GAME_YN)){
							$answer = $this->input->post('answer');
							$ans_time = date('Y-m-d H:i:s');
							
							$result = $this->game->log_game_yes_no($userID,$gameID,$answer,$ans_time);
							if($result > 0){

								//cập nhật bảng USERS, trừ point
								$user = $this->user->getUserById($userID);
								$user_point = $user->USER_POINT - FEE_BET_MINI;
								$this->user->updatePoint($userID,$user_point);
								//lấy point sau khi update
								$newUser = $this->user->getUserById($userID);

								//update lại bảng YN_GAMES (PLAYER_COUNT,TOTAL_AMOUNT)
								$game = $this->game->getGameYN_ById($gameID);
								$new_player_count = $game->PLAYER_COUNT + 1;
								$total_amount = $game->TOTAL_AMOUNT + FEE_BET_MINI;

								$this->game->update_Player_Total_Game($gameID,$new_player_count,$total_amount,GAME_YN);

								//lấy số lượng câu trả lời yes / no
								$ans = $this->game->getRatioYN($gameID);

								//danh sach bet game yn
								$list_bet_log = $this->game->get_Log_Game_By_Id($gameID,GAME_YN);

								//update tất cả các bảng log game yes no qua pusher
								$data['list_bet_log'] = $list_bet_log;
								$data['ans_yes'] = $ans['YES'];
								$data['ans_no'] = $ans['NO'];
								$data['total_amount'] = $total_amount;
								$data['gameID'] = $gameID;
																
								$this->pusher->trigger('log_game_yes_no_channel', 'log_game_yes_no_event', $data);
							
								$arr = array('result'=>1, 'user_point'=>$newUser->USER_POINT);

								echo json_encode($arr);
							}else{
								echo json_encode(0);
							}
						}else{
							echo json_encode(array('result'=>2));
						}					
					}else{
						echo json_encode(array('result'=>3));
					}
				}else{
					echo json_encode(array('result'=>4));
				}
			}else{
				echo json_encode(array('result'=>5));
			}

		}
	}

	/********************************* GAME MULTI ***********************************************/

	/**
	 * [createGameMulti description]
	 * @return [type] [description]
	 */
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
						$gameID = $this->game->createGameMulti($userID,$game_title,$start_date,$end_date,$price_below,$price_above);

						$game = $this->game->getGameMUL_ById($gameID);

						$user_point = $user_point - FEE_CREATE;
						$this->user->updatePoint($userID,$user_point);

						$userNew = $this->user->getUserById($userID);

						//call pusher để update item slide
						$data['gameID'] = $gameID;
						$data['game_title'] = $game_title;
						$data['user_create'] = $user->USER_NAME;
						$data['total_amount'] = $game->TOTAL_AMOUNT;
						$this->pusher->trigger('create_game_mul_channel', 'create_game_mul_event', $data);
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

	/**
	 * [mul description]
	 * @return [type] [description]
	 */
	public function mul()
	{
		$game_id = (int)$this->uri->segment(3);
		if($game_id > 0){
			//get data from table game yes no
			$user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
			if($user){
				$game = $this->game->getAllGameMiniActive();

				$data['USER_NAME'] = $user->USER_NAME;
	            $data['USER_POINT'] = $user->USER_POINT;

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

				// Lấy danh sách lịch sử log của game này
				$log_game = $this->game->get_Log_Game_By_Id($game_id,GAME_MUL);

				if($log_game){
					$data['list_bet_log'] = $log_game;
				}
				
				$data['game_data'] = $this->game->getGameMUL_ById($game_id);

				if($data['game_data']){
					//lay ti le phan tram nguoi choi da tra loi
					$ans = $this->game->getRatioMUL($game_id);
					
					$data['PRICE_BELOW'] = $ans['PRICE_BELOW'];
					$data['PRICE_BETWEEN'] = $ans['PRICE_BETWEEN'];
					$data['PRICE_ABOVE'] = $ans['PRICE_ABOVE'];

					// $this->load->view('layout/header');
					$this->load->view('game/gameMUL', $data);
					// $this->load->view('layout/footer');
				}else{
					$this->goHome();
				}

			}else{
				//GEST view
				$game = $this->game->getAllGameMiniActive();

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

				$data['game_data'] = $this->game->getGameMUL_ById($game_id);

				// Lấy danh sách lịch sử log của game này

				$log_game = $this->game->get_Log_Game_By_Id($game_id,GAME_MUL);

				if($log_game){					
					$data['list_bet_log'] = $log_game;
				}

				if($data['game_data']){
					//lay ti le phan tram nguoi choi da tra loi
					$ans = $this->game->getRatioMUL($game_id);
					
					$data['PRICE_BELOW'] = $ans['PRICE_BELOW'];
					$data['PRICE_BETWEEN'] = $ans['PRICE_BETWEEN'];
					$data['PRICE_ABOVE'] = $ans['PRICE_ABOVE'];

					// $this->load->view('layout/header');
					$this->load->view('game/gameMUL', $data);				
					// $this->load->view('layout/footer');
				}else{
					redirect(base_url());
				}
			}
		}else{			
			$this->goHome();
		}	
	}

	public function log_game_mul()
	{
		if(isset($_POST['game_id']) && isset($_POST['answer'])){
			$userID = $this->session->userdata('sessionUserId');
			$gameID = $this->input->post('game_id');
			//kiểm tra xem game đã full người chơi chưa
			if(!$this->game->isFull($gameID,GAME_MUL)){
				// Kiểm tra xem người chơi có phải là người tạo ra game này hay không
				if(!$this->user->isOwnerGame($userID,$gameID,GAME_MUL)){
					// Kiểm tra xem có đủ tiền chơi hay không?
					if($this->user->canPlayGame($userID)){
						//kiểm tra xem user đã đặt cược game này chưa
						if(!$this->game->is_log_game($userID,$gameID,GAME_MUL)){
							$answer = $this->input->post('answer');
							$ans_time = date('Y-m-d H:i:s');

							$price_below = false;
							$price_between= false;
							$price_above = false;

							if($answer == 0){
								$price_below = true;
							}else if($answer == 1){
								$price_between= true;
							}else if($answer == 2){
								$price_above = true;
							}
							
							$result = $this->game->log_game_mul($userID,$gameID,$price_below,$price_between,$price_above,$ans_time);

							if($result > 0){

								//cập nhật bảng USERS, trừ point
								$user = $this->user->getUserById($userID);
								$user_point = $user->USER_POINT - FEE_BET_MINI;
								$this->user->updatePoint($userID,$user_point);

								//lấy point sau khi update
								$newUser = $this->user->getUserById($userID);

								//update lại bảng MULTI_CHOICE_GAMES (PLAYER_COUNT,TOTAL_AMOUNT)
								$game = $this->game->getGameMUL_ById($gameID);
								$new_player_count = $game->PLAYER_COUNT + 1;
								$total_amount = $game->TOTAL_AMOUNT + FEE_BET_MINI;

								//TODO Update game multi
								$this->game->update_Player_Total_Game($gameID,$new_player_count,$total_amount,GAME_MUL);

								//lấy số lượng câu trả lời yes / no
								$ans = $this->game->getRatioMUL($gameID);

								$list_bet_log = $this->game->get_Log_Game_By_Id($gameID,GAME_MUL);					

								//update tất cả các bảng log game yes no qua pusher
								$data['list_bet_log'] = $list_bet_log;
								$data['gameID'] = $gameID;
								$data['total_amount'] = $total_amount;
								$data['PRICE_BELOW'] = $ans['PRICE_BELOW'];
								$data['PRICE_BETWEEN'] = $ans['PRICE_BETWEEN'];
								$data['PRICE_ABOVE'] = $ans['PRICE_ABOVE'];
								$this->pusher->trigger('log_game_mul_channel', 'log_game_mul_event', $data);

								$arr = array('result'=>1, 'user_point'=>$newUser->USER_POINT);

								echo json_encode($arr);
							}else{
								echo json_encode(0);
							}
						}else{
							echo json_encode(array('result'=>2));
						}					
					}else{
						echo json_encode(array('result'=>3));
					}
				}else{
					echo json_encode(array('result'=>4));
				}
			}else{
				echo json_encode(array('result'=>5));
			}
		}
	}

}

/* End of file GameCT.php */
/* Location: ./application/controllers/GameCT.php */