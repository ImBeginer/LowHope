<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	/********************************* GAME TT ***********************************************/

	/**
	 * [getGameTT description] get game TT after login
	 * @return [type] [description]
	 */
	public function getGameTT()
	{
		$this->db->select('*');
		$this->db->where('ACTIVE', 1);
		$this->db->order_by('GAME_ID', 'desc');
		$tt_game = $this->db->get('SYSTEM_GAMES', 1);

		if($tt_game){
			$tt_game = $tt_game->row();
			return $tt_game;			
		}else{
			throw new Exception('Error from getGameTT()');
		}

	}

	/**
	 * [addBetUser description]
	 * @param [type] $GAME_TT_ID [description]
	 * @param [type] $USER_ID    [description]
	 * @param [type] $PRICE      [description]
	 * @param [type] $DATE       [description]
	 */
	public function add_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE)
	{
		$bet = array('GAME_ID'=>$GAME_TT_ID, 'USER_ID'=> $USER_ID, 'PRICE_GUESS'=>$PRICE, 'DATE_GUESS' => $DATE);
		$this->db->insert('SYSTEM_GAME_LOGS', $bet);
		return $this->db->affected_rows()>0;
	}

	/**
	 * [check_His_User description] check history user in table his_game_tt
	 * @param  [type] $USER_ID    [description]
	 * @param  [type] $GAME_TT_ID [description]
	 * @return [type]             [description]
	 */
	public function check_Log_Game_TT($USER_ID, $GAME_TT_ID)
	{
		$his_user = array('GAME_ID' => $GAME_TT_ID, 'USER_ID' => $USER_ID);
		$this->db->select('*');
		$this->db->where($his_user);
		$result = $this->db->get('SYSTEM_GAME_LOGS');
		$rows = $result->num_rows();
		return ($rows>0)?true:false;
	}

	/**
	 * [updateBetUser description]
	 * @param  [type] $GAME_TT_ID [description]
	 * @param  [type] $USER_ID    [description]
	 * @param  [type] $PRICE      [description]
	 * @param  [type] $DATE       [description]
	 * @return [type]             [description]
	 */
	public function update_Log_Game_TT($GAME_TT_ID,$USER_ID,$PRICE,$DATE)
	{
		$bet = array('PRICE_GUESS'=>$PRICE, 'DATE_GUESS' => $DATE);
		$condi = array('GAME_ID'=>$GAME_TT_ID, 'USER_ID' => $USER_ID);
		$this->db->where($condi);
		$this->db->update('SYSTEM_GAME_LOGS', $bet);
		return $this->db->affected_rows()>0;
	}


	/********************** GAME MINI **************************/

	/**
	 * [createGameYN description]
	 * @param  [type] $userID     [description]
	 * @param  [type] $end_date   [description]
	 * @param  [type] $price_bet  [description]
	 * @param  [type] $start_date [description]
	 * @return [type]             [description]
	 */
	public function createGameYN($userID,$end_date,$price_bet,$start_date)
	{
		$game = array(
					'OWNER_ID' 		=> $userID,
					'CUR_TYPE_ID' 	=> 1,
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
			throw new Exception("Error from function createGameYN()");
		}
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
		$result = $this->db->get('YN_GAMESS');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from function checkGameYN()');
		}
	}
}

/* End of file game.php */
/* Location: ./application/models/game.php */