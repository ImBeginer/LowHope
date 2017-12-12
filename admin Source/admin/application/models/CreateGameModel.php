<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateGameModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	/**
	 * [checkGameYN description]
	 * @param  [type] $userID     [description]
	 * @param  [type] $start_date [description]
	 * @param  [type] $end_date   [description]
	 * @return [type]             [description]
	 */
	public function checkGameYN($userID,$start_date,$end_date)
	{
		$condi = array(
					'OWNER_ID' 		=> $userID,
					'START_DATE' 	=> $start_date,
					'END_DATE'		=> $end_date
				);
		$this->db->select('*');
		$this->db->where($condi);
		$result = $this->db->get('YN_GAMES');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from function checkGameYN()');
		}
	}

	/**
	 * [createGameYN description]
	 * @param  [type] $userID     [description]
	 * @param  [type] $end_date   [description]
	 * @param  [type] $price_bet  [description]
	 * @param  [type] $start_date [description]
	 * @return [type]             [description]
	 */
	public function createGameYN($userID,$game_title,$end_date,$price_bet,$start_date)
	{
		$game = array(
					'OWNER_ID' 		=> $userID,
					'CUR_TYPE_ID' 	=> 1,
					'TITLE'			=> $game_title,
					'START_DATE' 	=> $start_date,
					'END_DATE' 		=> $end_date,
					'PRICE_BET' 	=> $price_bet,
					'PLAYER_COUNT' 	=> 0,
					'ACTIVE' 		=>1
				);
		$result = $this->db->insert('YN_GAMES', $game);

		if($result){
			return $this->db->insert_id();
		}else{
			return 0;
		}
	}

	/**
	 * [getGameYN_ById description]
	 * @param  [type] $gameID [description]
	 * @return [type]         [description]
	 */
	public function getGameYN_ById($gameID)
	{
		$game = $this->db->select('YN_GAMES.GAME_ID, USERS.USER_NAME, YN_GAMES.TITLE, YN_GAMES.START_DATE, YN_GAMES.END_DATE, YN_GAMES.PRICE_BET, YN_GAMES.TOTAL_AMOUNT, YN_GAMES.PLAYER_COUNT, YN_GAMES.ACTIVE')->from('YN_GAMES')->join('USERS','YN_GAMES.OWNER_ID = USERS.USER_ID')->where('YN_GAMES.GAME_ID', $gameID);
		$game = $this->db->get();

		if($game && $game->num_rows()>0){
			$game = $game->row();
			return $game;
		}else{
			$game = null;
			return $game;
		}		
	}

	/**
	 * [checkGameMulti description]
	 * @param  [type] $userID     [description]
	 * @param  [type] $start_date [description]
	 * @param  [type] $end_date   [description]
	 * @return [type]             [description]
	 */
	public function checkGameMulti($userID,$start_date,$end_date)
	{
		$condi = array(
					'OWNER_ID' 		=> $userID,
					'START_DATE' 	=> $start_date,
					'END_DATE'		=> $end_date
				);
		$this->db->select('*');
		$this->db->where($condi);
		$result = $this->db->get('MULTI_CHOICE_GAMES');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from function checkGameMulti()');
		}
	}

	/**
	 * [createGameMulti description]
	 * @param  [type] $userID      [description]
	 * @param  [type] $game_title  [description]
	 * @param  [type] $start_date  [description]
	 * @param  [type] $end_date    [description]
	 * @param  [type] $price_below [description]
	 * @param  [type] $price_above [description]
	 * @return [type]              [description]
	 */
	public function createGameMulti($userID,$game_title,$start_date,$end_date,$price_below,$price_above)
	{
		$game = array(
					'OWNER_ID' 		=> $userID,
					'CUR_TYPE_ID' 	=> 1,
					'TITLE'			=> $game_title,
					'START_DATE' 	=> $start_date,
					'END_DATE' 		=> $end_date,
					'PRICE_BELOW' 	=> $price_below,
					'PRICE_ABOVE'	=> $price_above,
					'PLAYER_COUNT' 	=> 0,
					'ACTIVE' 		=>1
				);
		$result = $this->db->insert('MULTI_CHOICE_GAMES', $game);

		if($result){
			return $this->db->insert_id();
		}else{
			// throw new Exception("Error from function createGameMulti()");
			return 0;
		}
	}

	/**
	 * [getGameMUL_ById description]
	 * @param  [type] $gameID [description]
	 * @return [type]         [description]
	 */
	public function getGameMUL_ById($gameID)
	{
		$game = $this->db->select('MULTI_CHOICE_GAMES.GAME_ID, USERS.USER_NAME, MULTI_CHOICE_GAMES.TITLE, MULTI_CHOICE_GAMES.START_DATE, MULTI_CHOICE_GAMES.END_DATE, MULTI_CHOICE_GAMES.PRICE_BELOW, MULTI_CHOICE_GAMES.PRICE_ABOVE, MULTI_CHOICE_GAMES.PLAYER_COUNT, MULTI_CHOICE_GAMES.TOTAL_AMOUNT, MULTI_CHOICE_GAMES.ACTIVE')->from('MULTI_CHOICE_GAMES')->join('USERS','MULTI_CHOICE_GAMES.OWNER_ID = USERS.USER_ID')->where('MULTI_CHOICE_GAMES.GAME_ID', $gameID);
		$game = $this->db->get();

		if($game && $game->num_rows()>0){
			$game = $game->row();
			return $game;
		}else{
			$game = null;
			return $game;
		}
	}

}

/* End of file CreateGameModel.php */
/* Location: ./application/models/CreateGameModel.php */