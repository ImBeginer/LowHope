<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemGameDemoModel extends CI_Model {
    
    /**
     * [getAllManager description]
     * @return [type] [description]
     */
    function getCurrentGame()
    {
    	return $this->db->select('*')->from('SYSTEM_GAMES')->where('ACTIVE', 1)->get()->result_array();
    }

    /**
     * [updateManager description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function updateSysGameTime($id, $sys_date)
    {
    	$data = array(
           'END_DATE' => $sys_date
        );
		$this->db->where('GAME_ID', $id);
		$result = $this->db->update('SYSTEM_GAMES', $data); 
		if ($result)
        {
            return true;
        }
        return false;
    }
}