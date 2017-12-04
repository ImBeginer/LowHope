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
}