<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Model {

	public function __construct()
	{
		parent::__construct();		
	}

	public function getPriceCurrent()
	{
		$this->db->select('*');
		$this->db->order_by('UPDATE_AT', 'desc');
		$price = $this->db->get('CURRENCY_DETAILS', 1);
		$price = $price->row();
		return $price->PRICE;
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


	/********************************************* GAME MINI *********************************************/
	/**
	 * [getAllGameMini description]
	 * @return [type] [description]
	 */
	public function getAllGameMiniActive()
	{
		$game = array();

		$result_YN = $this->db->select('YN_GAMES.GAME_ID, YN_GAMES.OWNER_ID, USERS.USER_NAME, YN_GAMES.TITLE, YN_GAMES.TOTAL_AMOUNT')->from('YN_GAMES')->join('USERS','YN_GAMES.OWNER_ID = USERS.USER_ID')->where('YN_GAMES.ACTIVE',1);		

		$result_YN = $this->db->get();

		if($result_YN !== FALSE && $result_YN->num_rows()>0){
			$game['YN'] = $result_YN->result_array();
		}

		$result_MUL = $this->db->select('MULTI_CHOICE_GAMES.GAME_ID, MULTI_CHOICE_GAMES.OWNER_ID, USERS.USER_NAME, MULTI_CHOICE_GAMES.TITLE, MULTI_CHOICE_GAMES.TOTAL_AMOUNT')->from('MULTI_CHOICE_GAMES')->join('USERS','MULTI_CHOICE_GAMES.OWNER_ID = USERS.USER_ID')->where('MULTI_CHOICE_GAMES.ACTIVE',1);		

		$result_MUL = $this->db->get();

		if($result_MUL !== FALSE && $result_MUL->num_rows()>0){
			$game['MUL'] = $result_MUL->result_array();
		}

		return $game;
	}

	/**
	 * [getAllGameMini description]
	 * @return [type] [description]
	 */
	public function getAllGameMini()
	{
		$game = array();

		$game_YN = $this->db->select('YN_GAMES.GAME_ID, YN_GAMES.OWNER_ID, USERS.USER_NAME, YN_GAMES.TITLE, YN_GAMES.TOTAL_AMOUNT, YN_GAMES.END_DATE, YN_GAMES.ACTIVE, YN_GAMES.PRICE_BET')->from('YN_GAMES')->join('USERS','YN_GAMES.OWNER_ID = USERS.USER_ID');
		$game_YN = $this->db->get();
		if($game_YN !== false && $game_YN->num_rows()>0){
			$game['YN_ALL'] = $game_YN->result_array();
		}

		$game_MUL = $this->db->select('MULTI_CHOICE_GAMES.GAME_ID, MULTI_CHOICE_GAMES.OWNER_ID, USERS.USER_NAME, MULTI_CHOICE_GAMES.TITLE, MULTI_CHOICE_GAMES.PRICE_BELOW, MULTI_CHOICE_GAMES.PRICE_ABOVE, MULTI_CHOICE_GAMES.TOTAL_AMOUNT, MULTI_CHOICE_GAMES.END_DATE, MULTI_CHOICE_GAMES.ACTIVE')->from('MULTI_CHOICE_GAMES')->join('USERS','MULTI_CHOICE_GAMES.OWNER_ID = USERS.USER_ID');
		$game_MUL = $this->db->get();
		if($game_MUL !== false && $game_MUL->num_rows()>0){
			$game['MUL_ALL'] = $game_MUL->result_array();
		}
		return $game;
	}

	/**
	 * [is_log_game description]
	 * @param  [type]  $userID [description]
	 * @param  [type]  $gameID [description]
	 * @param  [type]  $type   [description]
	 * @return boolean         [description]
	 */
	public function is_log_game($userID,$gameID,$type)
	{
		$condi = array('USER_ID'=>$userID, 'GAME_ID'=>$gameID);
		$this->db->select('*');
		$this->db->where($condi);

		if($type == GAME_YN){
			$result = $this->db->get('YN_GAME_LOGS');
			if($result && $result->num_rows() > 0){
				return true;
			}else{
				return false;
			}			
		}else if($type == GAME_MUL){
			$result = $this->db->get('MULTI_CHOICE_GAME_LOGS');
			if($result && $result->num_rows() > 0){
				return true;
			}else{
				return false;
			}	
		}
	}

	/**
	 * [isFull description]
	 * @param  [type]  $gameID [description]
	 * @param  [type]  $type   [description]
	 * @return boolean         [description]
	 */
	public function isFull($gameID,$type)
	{
		if($type == GAME_YN){
			$result = $this->db->select('*')->where('GAME_ID',$gameID)->get('YN_GAMES');
			$result = $result->row();
			return $result->PLAYER_COUNT==MAX_PLAYER;
		}else if($type == GAME_MUL){
			$result = $this->db->select('*')->where('GAME_ID', $gameID)->get('MULTI_CHOICE_GAMES');
			$result = $result->row();
			return $result->PLAYER_COUNT==MAX_PLAYER;
		}
	}

	/**
	 * [update_Player_Total_Game description]
	 * @param  [type] $gameID           [description]
	 * @param  [type] $new_player_count [description]
	 * @param  [type] $total_amount     [description]
	 * @param  [type] $type             [description]
	 * @return [type]                   [description]
	 */
	public function update_Player_Total_Game($gameID,$new_player_count,$total_amount,$type)
	{
		$obj = array('PLAYER_COUNT' => $new_player_count, 'TOTAL_AMOUNT' => $total_amount);
		$this->db->where('GAME_ID', $gameID);

		if($type == GAME_YN){
			$this->db->update('YN_GAMES', $obj);
		}else if($type == GAME_MUL){
			$this->db->update('MULTI_CHOICE_GAMES', $obj);
		}
	}

	public function get_Log_Game_By_Id($game_id,$type)
	{
		$log_game = null;
		if($type == GAME_YN){
			$log_game = $this->db->select('YN_GAME_LOGS.GAME_ID, YN_GAME_LOGS.USER_ID, USERS.USER_NAME, YN_GAME_LOGS.ANS_TIME')->from('YN_GAME_LOGS')->join('USERS','YN_GAME_LOGS.USER_ID = USERS.USER_ID')->where('YN_GAME_LOGS.GAME_ID', $game_id);			
		}else if($type == GAME_MUL){
			$log_game = $this->db->select('MULTI_CHOICE_GAME_LOGS.GAME_ID, MULTI_CHOICE_GAME_LOGS.USER_ID, USERS.USER_NAME, MULTI_CHOICE_GAME_LOGS.ANS_TIME')->from('MULTI_CHOICE_GAME_LOGS')->join('USERS','MULTI_CHOICE_GAME_LOGS.USER_ID = USERS.USER_ID')->where('MULTI_CHOICE_GAME_LOGS.GAME_ID', $game_id);	
		}

		$log_game = $this->db->get();

		if($log_game && $log_game->num_rows()>0){
			$log_game = $log_game->result_array();
			return $log_game;
		}else{
			$log_game = null;
			return $log_game;
		}
	}

	/**************************************** YES/NO GAME *****************************************/

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
		$result = $this->db->get('YN_GAMES');
		if($result){
			$rows = $result->num_rows();
			return $rows>0;
		}else{
			throw new Exception('Error from function checkGameYN()');
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
	 * [log_game_yes_no description]
	 * @param  [type] $userID   [description]
	 * @param  [type] $gameID   [description]
	 * @param  [type] $answer   [description]
	 * @param  [type] $ans_time [description]
	 * @return [type]           [description]
	 */
	public function log_game_yes_no($userID,$gameID,$answer,$ans_time)
	{
		$log = array(
					'USER_ID' 	=> $userID,
					'GAME_ID' 	=> $gameID,
					'ANSWER' 	=> $answer,
					'ANS_TIME'	=> $ans_time
				);

		$this->db->insert('YN_GAME_LOGS', $log);
		return $this->db->affected_rows();
	}

	/**
	 * [getRatioYN description]
	 * @param  [type] $gameID [description]
	 * @return [type]         [description]
	 */
	public function getRatioYN($gameID)
	{
		$ans = array();

		$this->db->select('SUM(`ANSWER`=1) AS YES');
		$this->db->select('SUM(`ANSWER`=0) AS NO');
		$this->db->from('YN_GAME_LOGS');
		$this->db->where('GAME_ID', $gameID);

		$result = $this->db->get();
		$result = $result->row();
		$ans['YES'] = $result->YES;
		$ans['NO'] = $result->NO;

		return $ans;
	}

	/********************************************* MUL ***************************************************/
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
			throw new Exception("Error from function createGameMulti()");
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
	 * [log_game_mul description]
	 * @param  [type] $userID        [description]
	 * @param  [type] $gameID        [description]
	 * @param  [type] $price_below   [description]
	 * @param  [type] $price_between [description]
	 * @param  [type] $price_above   [description]
	 * @param  [type] $ans_time      [description]
	 * @return [type]                [description]
	 */
	public function log_game_mul($userID,$gameID,$price_below,$price_between,$price_above,$ans_time)
	{
		$log_game_mul = array(
						'USER_ID' => $userID,
						'GAME_ID' => $gameID,
						'PRICE_BELOW' => $price_below,
						'PRICE_BETWEEN' => $price_between,
						'PRICE_ABOVE' => $price_above,
						'ANS_TIME' => $ans_time
					);
		$this->db->insert('MULTI_CHOICE_GAME_LOGS', $log_game_mul);
		return $this->db->affected_rows();
	}

	/**
	 * [getRatioMUL description]
	 * @param  [type] $gameID [description]
	 * @return [type]         [description]
	 */
	public function getRatioMUL($gameID)
	{
		$ans = array();

		$this->db->select('SUM(`PRICE_BELOW`=1) AS PRICE_BELOW');
		$this->db->select('SUM(`PRICE_BETWEEN`=1) AS PRICE_BETWEEN');
		$this->db->select('SUM(`PRICE_ABOVE`=1) AS PRICE_ABOVE');
		$this->db->from('MULTI_CHOICE_GAME_LOGS');
		$this->db->where('GAME_ID', $gameID);

		$result = $this->db->get();
		$result = $result->row();
		$ans['PRICE_BELOW'] = $result->PRICE_BELOW;
		$ans['PRICE_BETWEEN'] = $result->PRICE_BETWEEN;
		$ans['PRICE_ABOVE'] = $result->PRICE_ABOVE;

		return $ans;
	}

}

/* End of file game.php */
/* Location: ./application/models/game.php */