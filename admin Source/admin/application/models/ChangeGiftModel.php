<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangeGiftModel extends CI_Model {
        /**
     * [getDefaultNoti load all default notification from db]
     * @return [type] [object]
     */
    function getDefaultNoti()
    {
        $result = $this->db->select('*')->from('NOTIFICATION')->get()->result_array();
        return $result;
    }

    /**
     * [getAward get]
     * @return [type] [description]
     */
    function getAward()
    {
    	// $this->db->limit(3);
    	// return $this->db->select('*')->from('AWARD')->order_by('AWARD_ID', 'desc')->get()->result_array();
    	return $this->db->select('*')->from('AWARD')->where('ACTIVE', 1)->get()->result_array();
    }

    /**
     * [getPassword description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    function getPassword($email)
    {
    	return $this->db->select('*')->from('USERS')->where('EMAIL', $email)->get()->row();
    }

	/**
	 * [updateActive deactive old award]
	 * @return [type] [description]
	 */
    function updateActive() {
    	$collection = $this->getAward();
    	foreach ($collection as $value) {
    		$data = array(
               'ACTIVE' => 0
            );
            $this->db->where('AWARD_ID', $value['AWARD_ID']);
			$check = $this->db->update('AWARD', $data); 
			if (!$check)  {
				return false;
			}
    	}
    	return true;
    }

    /**
     * [insertAward add 3 new award]
     * @param  [type] $win_1st [description]
     * @param  [type] $win_2nd [description]
     * @param  [type] $win_3rd [description]
     * @return [type]          [description]
     */
    function insertAward($win_1st, $win_2nd, $win_3rd)
    {
    	$data = array(
		   'PRIZE' => 1,
		   'AWARD_NAME' => $win_1st,
		   'ACTIVE' => 1
		);
		if ($this->db->insert('AWARD', $data)->affected_rows() == 0 ) {
			return false;
		}
		$data = array(
		   'PRIZE' => 2,
		   'AWARD_NAME' => $win_2nd,
		   'ACTIVE' => 1
		);
		if ($this->db->insert('AWARD', $data)->affected_rows() == 0 ) {
			return false;
		}
		$data = array(
		   'PRIZE' => 3,
		   'AWARD_NAME' => $win_3rd,
		   'ACTIVE' => 1
		);
		if ($this->db->insert('AWARD', $data)->affected_rows() == 0 ) {
			return false;
		}
		return true;
    }

    /**
     * [getAllUser get all player]
     * @return [type] [description]
     */
    function getAllUser()
    {
    	return $this->db->select('*')->from('USERS')->where('ROLE_ID', 3)->get()->result_array();
    }

    /**
     * [getCurrentSystemGame get current sys game]
     * @return [type] [description]
     */
    function getCurrentSystemGame() {
    	$this->db->select('*')->from('SYSTEM_GAMES')->where('ACTIVE', 1);
		return $this->db->get()->row();
    }

    /**
     * [insertNotiToAll insert noti to all player]
     * @param  [type] $noti_id [description]
     * @return [type]          [description]
     */
    function insertNotiToAll($noti_id)
    {
    	$user_list = $this->getAllUser();
    	$game_id = $this->getCurrentSystemGame();
    	foreach ($user_list as $user) {
    		date_default_timezone_set('Asia/Ho_Chi_Minh');
        	$date = date('Y-m-d H:i:s', time());
    		$data = array(
			   'USER_ID' => $user['USER_ID'] ,
			   'GAME_ID' => $game_id,
			   'TYPE_ID' => 3,
			   'SEND_DATE'=> $date,
			   'SEEN' => 0
			);
			$result = $this->db->insert('NOTIFICATION_DETAILS', $data); 
			if ($this->db->affected_rows() > 0) {
				return false;
			}
    	}
    	return true;
    }

}