<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditNotificationModel extends CI_Model {

    function getDefaultNoti()
    {
        $result = $this->db->select('*')->from('NOTIFICATION')->get()->result_array();
        return $result;
    }
}