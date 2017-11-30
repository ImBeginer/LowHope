<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditManagerModel extends CI_Model {
    /**
     * [getInfoById function to get User Infomation by id]
     * @param  [type] $id [user id]
     * @return [type]     [user object]
     */
    function getInfoById($id)
    {
        return $this->db->select("*")->from('USERS')->where('USER_ID', $id)->get()->row();
    }

    /**
     * [updateUserInfo description]
     * @param  [type] $id        [user id]
     * @param  [type] $user_name [user name]
     * @param  [type] $phone     [user phone]
     * @param  [type] $address   [user address]
     * @param  [type] $email     [user email]
     * @return [type]            [true to update success or false to update fail]
     */
    function updateUserInfo($id, $user_name, $phone, $address)
    {
        $data = array(
           'USER_NAME' => $user_name,
           'PHONE_NUMBER' => $phone,
           'ADDRESS' => $address
        );
        $this->db->where('USER_ID', $id);
        $result = $this->db->update('USERS', $data); 
        if ($result > 0) {
            return true;
        }
        return false;
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */