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
		$this->load->library('unit_test');

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
	 * [getGameTT description]
	 * @return [type] [description]
	 */
	public function getGameTT(){
		$game_tt = $this->game->getGameTT();
		echo json_encode($game_tt);
	}

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

			if($PRICE && (double)$PRICE > 0 && preg_match('/^\d+(\.(\d{2}))?$/', $PRICE)){

				$GAME_TT_ID = $this->session->userdata('session_Game_TT_ID');

				if($this->game->game_tt_alive($GAME_TT_ID)){

					$USER_ID = $this->session->userdata('sessionUserId');
					$DATE = date("Y-m-d H:i:s");

					$check_Log_Game_TT = $this->game->check_Log_Game_TT($USER_ID, $GAME_TT_ID);
					//Kiểm tra có đủ tiền để đặt cược game truyền thống hay không?
					$canBetGameTT = $this->user->canBetGameTT($USER_ID);

					if($canBetGameTT){
						if($check_Log_Game_TT){
							$check = $this->game->update_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
							if($check){
								$user = $this->user->getUserById($USER_ID);
								$res = array('result'=>1, 'user_point'=>$user->USER_POINT, 'price_bet'=>$PRICE);
								echo json_encode($res);
							}else{
								$res = array('result'=>0);
								echo json_encode($res);
							}
						}else{
							$check = $this->game->add_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE);
							if($check){
								$user = $this->user->getUserById($USER_ID);
								$user_point = $user->USER_POINT;
								$user_point = $user_point - FEE_BET_TT;
								$this->user->updatePoint($USER_ID,$user_point);
								$userNew = $this->user->getUserById($USER_ID);

								$res = array('result'=>1, 'user_point'=>$userNew->USER_POINT, 'price_bet'=>$PRICE);
								echo json_encode($res);
							}else{
								$res = array('result'=>0);
								echo json_encode($res);
							}
						} 
					}else{
						$res = array('result'=>3);
						echo json_encode($res);
					}
				}else{
					$res = array('result'=>4);
					echo json_encode($res);
				}
			}else {
				$res = array('result'=>2);
				echo json_encode($res);
			}
		}else{
			$res = array('result'=>0);
			echo json_encode($res);
		}
	}

	function update_session_game_tt()
	{
		$gameID = $this->input->post('gameID');
		$roomID = $this->user->get_room_by_game_id($gameID);
		
		$this->session->set_userdata('session_Game_TT_ID', $gameID);
		//update session room
		$this->session->set_userdata('session_room', $roomID);

		//game mới
		$new_game = $this->game->get_game_tt_by_id($gameID);
		//giải thưởng
		$top_users_achievement = $this->user->get_user_achievement_before();
		
		echo json_encode(array('new_game'=>$new_game, 'top_users_achievement'=>$top_users_achievement));
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

					if($price_bet && (double)$price_bet > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_bet)){
						//ngày hiện tại nhỏ hơn ngày kết thúc
						if(strtotime($end_date) > strtotime($start_date)){
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

								echo json_encode(array('create'=>1, 'user_point'=>$userNew->USER_POINT, 'game_id'=>$gameID));					
							}else{
								echo json_encode(array('create'=>0));
							}
						}else{
							echo json_encode(array('create'=>3));
						}
					}else{
						echo json_encode(array('create'=>4));
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

                $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
                $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
                $data['top_point'] = $this->user->get_top_point();

				$data['game_data'] = $this->game->getGameYN_ById($game_id);
				$data['user_id'] = $user->USER_ID;
				$data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
        		$data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
        		$data['top_users_achievement'] = $this->user->get_user_achievement_before();

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
				//load game active
                $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
                $data['top_users_achievement'] = $this->user->get_user_achievement_before();

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

			//Kiểm tra game kết thúc rồi thì không đặt được nữa
			if(!$this->game->isClosed($gameID,GAME_YN)){
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
			}else{
				echo json_encode(array('result'=>6));
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

					if($price_below && (double)$price_below > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_below) && $price_above && (double)$price_above > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_above)){
						if(strtotime($end_date) > strtotime($start_date)){
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
								echo json_encode(array('create'=>1, 'user_point'=>$userNew->USER_POINT, 'game_id'=>$gameID));
							}else{
								echo json_encode(array('create'=>0));
							}
						}else{
							echo json_encode(array('create'=>3));
						}
					}else{
						echo json_encode(array('create'=>4));
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

				$data['USER_NAME'] = $user->USER_NAME;
	            $data['USER_POINT'] = $user->USER_POINT;

                $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
                $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
                $data['top_point'] = $this->user->get_top_point();

				// Lấy danh sách lịch sử log của game này
				$log_game = $this->game->get_Log_Game_By_Id($game_id,GAME_MUL);

				if($log_game){
					$data['list_bet_log'] = $log_game;
				}
				
				$data['game_data'] = $this->game->getGameMUL_ById($game_id);
				$data['user_id'] = $user->USER_ID;
				$data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
        		$data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
        		$data['top_users_achievement'] = $this->user->get_user_achievement_before();

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
				//load game active
                $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
                $data['top_users_achievement'] = $this->user->get_user_achievement_before();

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
			//Kiểm tra game kết thúc rồi thì không đặt được nữa
			if(!$this->game->isClosed($gameID,GAME_MUL)){
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
			}else{
				echo json_encode(array('result'=>6));
			}
		}
	}

	/********************************* CHAT *********************************/
	/**
	 * send message to all client and add to database
	 * @return [type] [description]
	 */
	public function send_message_chat()
	{
		$userID = $this->session->userdata('sessionUserId');
		$gameID = $this->session->userdata('session_Game_TT_ID');
		$roomID = $this->session->userdata('session_room');

		$send_date = date("Y-m-d H:i:s");
		$message = $this->input->post('message');

		$data['userName'] 	= $this->input->post('userName');
		$data['avatar']		= $this->input->post('avatar');
		$data['message']	= $message;
		$data['send_date'] 	= $send_date;
		$data['userID'] 	= $userID;

		if($this->user->add_message_chat($roomID, $userID, $message, $send_date) > 0){
			$this->pusher->trigger('channel_room_chat', 'receive_message', $data);
		}
	}


	function unit_test_game_activities()
	{

		//$this->unit->run($this->game->get_game_tt_by_id(77), $expected = 'is_object','Kiểm tra lấy nội dung game truyền thống theo id.');

		// $this->unit->run($this->game->get_game_tt_by_id(777), $expected = 'is_null','Kiểm tra lấy nội dung game truyền thống theo id.');
		 
		// $this->unit->run($this->game->game_tt_alive(77), $expected = true,'Kiểm tra xem game truyền thống có trong trạng thái active không.');

		// $this->unit->run($this->game->game_tt_alive(72), $expected = false,'Kiểm tra xem game truyền thống có trong trạng thái deactive không.');

		// $this->unit->run($this->game->check_Log_Game_TT(3, 72), $expected = false,'Kiểm tra xem người chơi đã đặt cược chơi game truyền thống hay chưa.');

		// $this->unit->run($this->game->check_Log_Game_TT(4, 72), $expected = true,'Kiểm tra xem người chơi đã đặt cược chơi game truyền thống hay chưa.');

		// $this->unit->run($this->game->update_Log_Game_TT(77, 40, 11000, date("Y-m-d H:i:s")), $expected = true,'Update lại giá bitcoin đã cược của người chơi.');
		 
		// $this->unit->run($this->game->update_Log_Game_TT(777, 40, 11000, date("Y-m-d H:i:s")), $expected = false,'Update không thành công giá bitcoin đã cược của người chơi.');

		// $this->unit->run($this->game->add_Log_Game_TT(77, 4, 15000, date("Y-m-d H:i:s")), $expected = true,'Ad giá bitcoin cược của người chơi.');
		
		// $this->unit->run($this->game->add_Log_Game_TT(77, 444, 15000, date("Y-m-d H:i:s")), $expected = false,'Ad giá bitcoin cược của người chơi.');
		 
		// $this->unit->run($this->game->checkGameYN(4, '2017-12-05 22:58:35', '2017-12-05 23:20:00'), $expected = true,'Kiểm tra người chơi đã tạo game yes/no.');

		// $this->unit->run($this->game->checkGameYN(1, '2017-12-05 22:58:35', '2017-12-05 23:20:00'), $expected = false,'Kiểm tra người chơi chưa tạo game yes/no.');
		
		// $this->unit->run($this->game->createGameYN(4, 'Unitest_Tạo game Yes/No', '2017-12-19 22:58:35', 16000,'2017-12-25 23:20:00'), $expected = 80,'Kiểm tra người chơi tạo game yes/no thành công.');
		 
		// $this->unit->run($this->game->createGameYN(444, 'Unitest_Tạo game Yes/No', '2017-12-19 22:58:35', 16000,'2017-12-25 23:20:00'), $expected = 0,'Kiểm tra người chơi tạo game yes/no không thành công.');
		
		$this->unit->run($this->game->getGameYN_ById(1147), $expected = 'is_object','Kiểm tra lấy thông tin thành công game yes/no theo ID.');
		 
		// $this->unit->run($this->game->getGameYN_ById(800), $expected = null, 'Kiểm tra lấy thông tin không thành công game yes/no theo ID.');
		
		// $this->unit->run($this->game->isClosed(74, GAME_YN), $expected = true, 'Kiểm tra game yes/no đã đóng theo ID.');
		
		// $this->unit->run($this->game->isClosed(80, GAME_YN), $expected = false, 'Kiểm tra game yes/no chưa đóng theo ID.');
		
		// $this->unit->run($this->game->isFull(80, GAME_YN), $expected = false, 'Kiểm tra game yes/no đã đủ người theo ID.');
		
		// $this->unit->run($this->game->is_log_game(4, 80, GAME_YN), $expected = false, 'Kiểm tra người đã chơi game yes/no này chưa.');
		
		// $this->unit->run($this->game->is_log_game(4, 74, GAME_YN), $expected = true, 'Kiểm tra người đã chơi game yes/no này.');
		
		// $this->unit->run($this->game->log_game_yes_no(1, 80, true, date("Y-m-d H:i:s")), $expected = 1, 'Kiểm tra người cược game yes/no thành công.');
		
		// $this->unit->run($this->game->log_game_yes_no(1, 800, true, date("Y-m-d H:i:s")), $expected = -1, 'Kiểm tra người cược game yes/no không thành công.');
		
		// $this->unit->run($this->game->load_games_active(), $expected = 'is_array', 'Kiểm tra danh sách game mini active.');
		
		// $this->unit->run($this->game->get_Log_Game_By_Id(71,1), $expected = 'is_array', 'Kiểm tra danh sách những người đã cược game yes/no.');
		
		// $this->unit->run($this->game->get_Log_Game_By_Id(35,2), $expected = 'is_array', 'Kiểm tra danh sách những người đã cược game multiple choice.');
		
		// $this->unit->run($this->game->getRatioYN(74), $expected = 'is_array', 'Kiểm tra tỉ lệ đặt cược của 1 game yes/no.');
		
		// $this->unit->run($this->game->getRatioYN(775), $expected = empty(array()), 'Kiểm tra tỉ lệ đặt cược của 1 game yes/no.');
		
		// $this->unit->run($this->game->checkGameMulti(4, '2017-12-11 19:48:12', '2017-12-12 14:22:00'), $expected = false, 'Kiểm tra người chơi đã tạo game multi này chưa.');
		
		// $this->unit->run($this->game->checkGameMulti(39, '2017-12-11 19:48:12', '2017-12-12 14:22:00'), $expected = true, 'Kiểm tra người chơi đã tạo game multi này chưa.');
		
		// $this->unit->run($this->game->createGameMulti(444, 'Khử thằng Vinh Vạm Vỡ','2017-12-11 19:48:12', '2017-12-29 14:22:00', 14000, 14000), $expected = 0, 'Kiểm tra người chơi không tồn tại tạo game multi.');
		
		// $this->unit->run($this->game->getGameMUL_ById(34), $expected = 'is_object', 'Kiểm tra thông tin game multi.');
		
		// $this->unit->run($this->game->getGameMUL_ById(344), $expected = null, 'Kiểm tra thông tin game multi không tồn tại.');
		
		// $this->unit->run($this->game->getRatioMUL(344), $expected = empty(array()), 'Kiểm tra thông tin tỉ lệ đặt cược game multi không tồn tại.');
		
		// $this->unit->run($this->game->getRatioMUL(34), $expected = 'is_array', 'Kiểm tra thành công thông tin tỉ lệ đặt cược game multi.');
		$this->load->view('game/unitTestGame');
	}
}

/* End of file GameCT.php */
/* Location: ./application/controllers/GameCT.php */