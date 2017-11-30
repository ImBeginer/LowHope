<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CultureGameModel extends CI_Model {

    /**
     * [getAllCultureGame description]
     * @return [type] [list of culture game of false if no exit any game]
     */
    function getAllCultureGame()
    {
        $result = $this->db->select('*')->from('SYSTEM_GAMES')->order_by("GAME_ID", "desc")->get()->result_array();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */