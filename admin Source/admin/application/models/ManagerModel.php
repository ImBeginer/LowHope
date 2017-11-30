<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerModel extends CI_Model {
    /**
     * [getInfoById function to get User Infomation by id]
     * @param  [type] $id [user id]
     * @return [type]     [user object]
     */
    function getInfoById($id)
    {
        return $this->db->select("*")->from('USERS')->where('USER_ID', $id)->get()->row();
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */