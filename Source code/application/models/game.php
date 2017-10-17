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

}

/* End of file game.php */
/* Location: ./application/models/game.php */