<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CultureGameDetailModel extends CI_Model {

    /**
     * [getGameDetail description]
     * @param  [type] $id   [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    function getGameDetail($id)
    {
        $this->db->select('*');
        $this->db->from('SYSTEM_GAMES');
        $this->db->where('GAME_ID', $id);
        $result = $this->db->get()->row();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * [getPlayer description]
     * @param  [type] $id [description]
     * @return [type]     [object list of player or false]
     */
    function getPlayer($id) 
    {
        $result = $this->db->select('*')->from('SYSTEM_GAME_LOGS')->where('GAME_ID', $id)->get()->result_array();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    /**
     * [getJoinerList description]
     * @param  [type] $type [game type - YN or MC]
     * @param  [type] $id   [game id]
     * @return [type]       [list of user join in this game]
     */
    function getJoinerList($id)
    {
        $this->db->select('*');
        $this->db->from('SYSTEM_GAME_LOGS');
        $this->db->join('USERS', 'USERS.USER_ID = SYSTEM_GAME_LOGS.USER_ID');
        $this->db->where('GAME_ID', $id);
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // TODO
    /**
     * [getChampion description]
     * @param  [type] $game_id [description]
     * @return [type]          [description]
     */
    function getChampion($game_id)
    {
        $this->db->select('*');
        $this->db->from('ACHIEVEMENT');
        $this->db->where('GAME_ID', $game_id);
        $this->db->order_by("A_ID", "asc"); 
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}