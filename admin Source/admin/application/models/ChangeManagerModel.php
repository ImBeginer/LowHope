<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangeManagerModel extends CI_Model {

	/**
	 * [getActiveManager description]
	 * @return [type] [description]
	 */
    function getActiveManager()
    {
        return $this->db->select('*')->from('USERS')->where('ROLE_ID', 2)->where('ACTIVE', 1)->get()->result_array();
    }

    /**
     * [getDeactiveManager description]
     * @return [type] [description]
     */
    function getDeactiveManager()
    {
        return $this->db->select('*')->from('USERS')->where('ROLE_ID', 2)->where('ACTIVE', 0)->get()->result_array();
    }

    /**
     * [blockManager description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function blockManager($id)
    {
    	$data = array(
               'ACTIVE' => 0
            );

		$this->db->where('USER_ID', $id);
		$result = $this->db->update('USERS', $data); 
		if (count($result) > 0) {
			return true;
		}
		return false;
    }

    /**
     * [unblockManager description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function unblockManager($id)
    {
    	$data = array(
           'ACTIVE' => 1
        );

		$this->db->where('USER_ID', $id);
		$result = $this->db->update('USERS', $data); 
		if (count($result) > 0) {
			return true;
		}
		return false;
    }
}