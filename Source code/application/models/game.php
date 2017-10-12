<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	/********************************* GAME TT ***********************************************/

	/**
	 * [getGameTT description] get game TT after login
	 * @return [type] [description]
	 */
	public function getGameTT()
	{
		$this->db->select('*');
		$this->db->where('ACTIVE', true);
		$this->db->order_by('GAME_ID', 'desc');
		$tt_game = $this->db->get('TT_GAME', 1);
		$tt_game = $tt_game->row();
		return $tt_game;
	}

	/**
	 * [check_His_User description] check history user in table his_game_tt
	 * @param  [type] $USER_ID    [description]
	 * @param  [type] $GAME_TT_ID [description]
	 * @return [type]             [description]
	 */
	public function check_His_User($USER_ID, $GAME_TT_ID)
	{
		$his_user = array('GAME_TT_ID' => $GAME_TT_ID, 'USER_ID' => $USER_ID);
		$this->db->select('*');
		$this->db->where($his_user);
		$result = $this->db->get('HIS_GAME_TT');
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
	public function updateBetUser($GAME_TT_ID,$USER_ID,$PRICE,$DATE)
	{
		$bet = array('PRICE'=>$PRICE, 'DATE' => $DATE);
		$condi = array('GAME_TT_ID'=>$GAME_TT_ID, 'USER_ID' => $USER_ID);
		$this->db->where($condi);
		$this->db->update('HIS_GAME_TT', $bet);
		return $this->db->affected_rows()>0;
	}

	/**
	 * [addBetUser description]
	 * @param [type] $GAME_TT_ID [description]
	 * @param [type] $USER_ID    [description]
	 * @param [type] $PRICE      [description]
	 * @param [type] $DATE       [description]
	 */
	public function addBetUser($GAME_TT_ID,$USER_ID,$PRICE,$DATE)
	{
		$bet = array('GAME_TT_ID'=>$GAME_TT_ID, 'USER_ID'=> $USER_ID, 'PRICE'=>$PRICE, 'DATE' => $DATE);
		$this->db->insert('HIS_GAME_TT', $bet);
		return $this->db->insert_id()>0;
	}

}

/* End of file game.php */
/* Location: ./application/models/game.php */