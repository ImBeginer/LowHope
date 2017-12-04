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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s', time());
        if ($id == -1) {
            $data = array(
               'TITLE' => $title,
               'CONTENT' => $content,
               'CREATE_DATE' => $date
            );
            $this->db->insert('NOTIFICATION', $data); 
        } else {
            $data = array(
                'TITLE' => $title,
                'CONTENT' => $content,
                'CREATE_DATE' => $date
            );
            $this->db->where('NOTICE_ID', $id);
            $result = $this->db->update('NOTIFICATION', $data); 
        }
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    function deleteNoti($id)
    {
        $this->db->where('NOTICE_ID', $id);
        $result = $this->db->delete('NOTIFICATION'); 
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

}