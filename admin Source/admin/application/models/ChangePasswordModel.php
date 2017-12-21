<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangePasswordModel extends CI_Model {

    /**
     * [getOldPassword get old password]
     * @param  [type] $userId [description]
     * @return [type]         [password]
     */
    function getOldPassword($userId)
    {
        return $this->db->select('*')->from('USERS')->where('USER_ID', $userId)->get()->row()->PASSWORD;
    }

    /**
     * [updatePassword description]
     * @param  [type] $userId   [user id]
     * @param  [type] $password [new pass]
     * @return [type]           [true or false]
     */
    function updatePassword($userId, $password)
    {
        $data = array( 'PASSWORD' => $password );
        $this->db->where('USER_ID', $userId);
        $result = $this->db->update('USERS', $data);
        if ($result)
        {
            return true;
        }
        return false;
    }

}