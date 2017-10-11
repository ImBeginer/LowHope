<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getGameTT()
	{
		$this->db->select('*');
		$this->db->where('ACTIVE', true);
		$this->db->order_by('GAME_ID', 'desc');
		$tt_game = $this->db->get('TT_GAME', 1);
		$tt_game = $tt_game->row();
		return $tt_game;
	}

}

/* End of file game.php */
/* Location: ./application/models/game.php */