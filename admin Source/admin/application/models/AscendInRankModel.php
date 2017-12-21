<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AscendInRankModel extends CI_Model {
    
    /**
     * [getAllManager description]
     * @return [type] [description]
     */
    function getAllManager()
    {
    	return $this->db->select('*')->from('USERS')->where('ROLE_ID', 2)->get()->result_array();
    }

    /**
     * [getAllUserOderByPoint description]
     * @return [type] [description]
     */
    public function getAllUserOderByPoint()
    {
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('ROLE_ID', 3);
        $this->db->order_by("USER_POINT", "desc"); 
        $result = $this->db->get()->result_array();
        return ($result);
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
