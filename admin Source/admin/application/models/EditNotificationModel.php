<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditNotificationModel extends CI_Model {

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
     * [updateNoti description]
     * @param  [type] $id      [notice id]
     * @param  [type] $title   [notice title]
     * @param  [type] $content [notice content]
     * @return [type]          [true to update success or false to update fail]
     */
    function updateNoti($id, $title, $content)
    {
        $data = array();
        if ($id == -1) {
            $data = array(
               'TITLE' => $title,
               'CONTENT' => $content
            );
        } else {
            $data = array(
                'NOTICE_ID' => $id,
                'TITLE' => $title,
                'CONTENT' => $content
            );
        }
        $this->db->where('NOTICE_ID', $id);
        $result = $this->db->update('NOTIFICATION', $data); 
        if ($result > 0) {
            return true;
        }
        return false;
    }

}