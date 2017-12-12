<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH .'/vendor/autoload.php';
class CreateGame extends CI_Controller {
	public $pusher;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('CreateGameModel');

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

	public function index()
	{
		if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == true) {
			$user = $this->session->userdata('user');   
            $user_name = $user['USER_NAME'];
            $user_id = $user['USER_ID'];
            $role_id = $user['ROLE_ID'];
            if ($role_id != 1) {
                redirect(base_url().'Login','refresh');
            }
            $data['userName'] = $user_name;
            $data['userId'] = $user_id;

			$this->load->view('CreateGame', $data);
		}else{
			redirect(base_url().'Login','refresh');
		}
	}

	public function createGameYN()
	{
		if(isset($_POST['game_title']) && isset($_POST['end_date_time']) && isset($_POST['price_bet'])){
			try {
				$user = $this->session->userdata('user'); 
				$userID = $user['USER_ID'];			
				$game_title = $this->input->post('game_title');

				$end_date = $this->input->post('end_date_time');
				$end_date = date('Y-m-d H:i:s', (double)$end_date/1000);

				$price_bet = $this->input->post('price_bet');
				$start_date = date('Y-m-d H:i:s');

				if($price_bet && (double)$price_bet > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_bet)){
					//ngày hiện tại nhỏ hơn ngày kết thúc
					if(strtotime($end_date) > strtotime($start_date)){
						if(!$this->CreateGameModel->checkGameYN($userID, $start_date, $end_date)){

							$gameID = $this->CreateGameModel->createGameYN($userID, $game_title, $end_date, $price_bet, $start_date);

							$game = $this->CreateGameModel->getGameYN_ById($gameID);

							//call pusher để update item slide
							$data['gameID'] = $gameID;
							$data['game_title'] = $game_title;
							$data['user_create'] = $user['USER_NAME'];
							$data['total_amount'] = $game->TOTAL_AMOUNT;

							$this->pusher->trigger('create_game_yes_no_channel', 'create_game_yes_no_event', $data);

							echo json_encode(array('create'=>1, 'game_id'=>$gameID));					
						}else{
							echo json_encode(array('create'=>0));
						}
					}else{
						echo json_encode(array('create'=>3));
					}
				}else{
					echo json_encode(array('create'=>4));
				}
			} catch (Exception $e) {
				file_put_contents(APPPATH.'logs/lowhope.log',"\n".$e->getMessage()." IN FILE ".$e->getfile()." AT LINE :".$e->getline(), FILE_APPEND);
				echo json_encode("0");
			}
		}
	}

	/**
	 * [createGameMulti description]
	 * @return [type] [description]
	 */
	public function createGameMulti()
	{
		if(isset($_POST['game_title_mul']) && isset($_POST['end_date_time']) && isset($_POST['price_below']) && isset($_POST['price_above'])){
			try {
				
				$user = $this->session->userdata('user'); 
				$userID = $user['USER_ID'];		

				$game_title = $this->input->post('game_title_mul');
				$start_date = date('Y-m-d H:i:s');

				$end_date = $this->input->post('end_date_time');
				$end_date = date('Y-m-d H:i:s', (double)$end_date/1000);

				$price_below = $this->input->post('price_below');
				$price_above = $this->input->post('price_above');

				if($price_below && (double)$price_below > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_below) && $price_above && (double)$price_above > 0 && preg_match('/^\d+(\.(\d{1,2}))?$/', $price_above)){
					if(strtotime($end_date) > strtotime($start_date)){
						if(!$this->CreateGameModel->checkGameMulti($userID,$start_date,$end_date)){
							$gameID = $this->CreateGameModel->createGameMulti($userID,$game_title,$start_date,$end_date,$price_below,$price_above);

							$game = $this->CreateGameModel->getGameMUL_ById($gameID);

							//call pusher để update item slide
							$data['gameID'] = $gameID;
							$data['game_title'] = $game_title;
							$data['user_create'] = $user['USER_NAME'];
							$data['total_amount'] = $game->TOTAL_AMOUNT;
							$this->pusher->trigger('create_game_mul_channel', 'create_game_mul_event', $data);
							echo json_encode(array('create'=>1, 'game_id'=>$gameID));
						}else{
							echo json_encode(array('create'=>0));
						}
					}else{
						echo json_encode(array('create'=>3));
					}
				}else{
					echo json_encode(array('create'=>4));
				}
			} catch (Exception $e) {
				file_put_contents(APPPATH.'logs/lowhope.log',"\n".$e->getMessage()." IN FILE ".$e->getfile()." AT LINE :".$e->getline(), FILE_APPEND);
				echo json_encode("0");
			}
		}
	}

}

/* End of file createGame.php */
/* Location: ./application/controllers/createGame.php */