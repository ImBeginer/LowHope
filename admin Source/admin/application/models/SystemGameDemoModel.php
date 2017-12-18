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
    function updateManager($id)
    {
    	$data = array(
           'ROLE_ID' => 2
        );
		$this->db->where('USER_ID', $id);
		$result = $this->db->update('USERS', $data); 
		if ($result)
        {
            return true;
        }
        return false;
    }
}
