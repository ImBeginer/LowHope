<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameDetailModel extends CI_Model {

    /**
     * [getGameDetail description]
     * @param  [type] $id   [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    function getGameDetail($type,$id)
    {
        $this->db->select('*');
        if ($type == "YN") {
            $this->db->from('YN_GAMES');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->row();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else if ($type == "MC") {
            $this->db->from('MULTI_CHOICE_GAMES');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->row();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * [getNameOwner description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function getNameOwner($id)
    {
        $this->db->select('*')->from('USERS')->where('USER_ID', $id);
        $result = $this->db->get()->row();
        return ($result->USER_NAME);
    }

    /**
     * [getJoinerList description]
     * @param  [type] $type [game type - YN or MC]
     * @param  [type] $id   [game id]
     * @return [type]       [list of user join in this game]
     */
    function getJoinerList($type, $id)
    {
         $this->db->select('*');
        if ($type == "YN") {
            $this->db->from('YN_GAME_LOGS');
            $this->db->join('USERS', 'USERS.USER_ID = YN_GAME_LOGS.USER_ID');
            // $query = $this->db->get();
            // $this->db->from('YN_GAMES_LOGS');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->result_array();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else if ($type == "MC") {
            $this->db->from('MULTI_CHOICE_GAME_LOGS');
            $this->db->join('USERS', 'USERS.USER_ID = MULTI_CHOICE_GAME_LOGS.USER_ID');
            // $this->db->from('MULTI_CHOICE_GAMES_LOGS');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->result_array();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */