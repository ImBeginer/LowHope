<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class NotiModel extends CI_Model { 

    /**
     * load first when login
     * @return list of  member order by created date
     */
    public function getAllMember()
    {   
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('ROLE_ID', 3); 
        $this->db->order_by("CREATE_DATE", "desc"); 
        $result = $this->db->get()->result_array();
        return ($result);
    } 

    /**
     * load first when login
     * @return list of new members
     */
    public function getNewMember()
    {
        $month = date('m', strtotime('first day of last month'));
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('MONTH(CREATE_DATE)', $month); 
        $this->db->where('ROLE_ID', 3);         
        $this->db->order_by("CREATE_DATE", "desc"); 
        return ($this->db->get()->result_array());
    } 

    /**
     * load first when login
     * @return top 3 champions
     */
    public function getChampions()
    {   
        $this->db->limit(3);
        // $this->db->select('*');
        // $this->db->from('ACHIEVEMENT');  
        // $this->db->order_by("GET_AT", "desc"); 
        $result = $this->db->select('ACHIEVEMENT.USER_ID, USERS.USER_NAME, USERS.CREATE_DATE, USERS.AVATAR')->from('ACHIEVEMENT')->join('USERS','ACHIEVEMENT.USER_ID = USERS.USER_ID')->order_by("GET_AT", "desc");    

        $result = $this->db->get()->result_array();
        // print_r($result);
        return ($result);
    } 

    /**
     * load first when login
     * @return informations of this id
     */
    public function getInformationById($id) {
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('USER_ID', $id);
        return ($this->db->get()->row());
    }


    /**
     * [getDefaultNoti get all noti from db]
     * @return [list] [description]
     */
    public function getDefaultNoti() 
    {
        $this->db->select('*');
        $this->db->from('NOTIFICATION');
        return ($this->db->get()->result_array());
    }

    /**
     * [getDefaultNoti get all noti from db]
     * @return [list] [description]
     */
    public function getNotiById($id) 
    {
        $this->db->select('*');
        $this->db->from('NOTIFICATION');
        $this->db->where('NOTICE_ID', $id);
        return ($this->db->get()->row());
    }

    /**
     * [getDetailNoti description]
     * @param  [type] $noti_id [description]
     * @return [type]          [description]
     */
    public function getDetailNoti($noti_id, $lUserId, $date)
    {
        $this->db->select('*');
        $this->db->from('NOTIFICATION_DETAILS');
        $this->db->join('NOTIFICATION', 'NOTIFICATION.NOTICE_ID = NOTIFICATION_DETAILS.NOTICE_ID');
        $this->db->join('USERS', 'USERS.USER_ID = NOTIFICATION_DETAILS.USER_ID');
        $this->db->where('NOTIFICATION_DETAILS.NOTICE_ID', $noti_id);
        $this->db->where('NOTIFICATION_DETAILS.SEND_DATE', $date);
        $this->db->where_in('NOTIFICATION_DETAILS.USER_ID', $lUserId);
        return ($this->db->get()->result_array());
    }

    /**
     * [sentNotification description]
     * @param  [type] $lId     [list id user]
     * @param  [type] $content [content]
     * @return [type]          [1 is sucess 2 is fail]
     */
    public function sentNotification($lUserId, $contentId, $date)
    {
        try {
            foreach ($lUserId as $id) {

                $data = array(
                'NOTICE_ID' => $contentId,
                'USER_ID' =>  $id,
                'TYPE_ID' => 4, 
                'SEND_DATE' => $date,
                'SEEN' => '0'    
                ); 
                $this->db->insert('NOTIFICATION_DETAILS', $data);
                $check = $this->db->affected_rows();
                if ($check == 0) {
                    return 0;
                }
            }
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * [countWin description]
     * @param  [type] $id [description]
     * @return [type]     [number of win time]
     */
    function countYNWin($id)
    {
        $this->db->where('IS_WINNER', true);
        $this->db->where('USER_ID', $id);
        $this->db->from('YN_GAME_LOGS');
        return $this->db->count_all_results();
    }

    /**
     * [countWin description]
     * @param  [type] $id [description]
     * @return [type]     [number of win time]
     */
    function countMCWin($id)
    {
        $this->db->where('IS_WINNER', true);
        $this->db->where('USER_ID', $id);
        $this->db->from('MULTI_CHOICE_GAME_LOGS');
        return $this->db->count_all_results();
    }

    /**
     * [countWin description]
     * @param  [type] $id [description]
     * @return [type]     [number of win time]
     */
    function countWin($id)
    {
        $MC = $this->countMCWin($id);
        $YN = $this->countYNWin($id);
        return ($MC + $YN);
    }

    /**
     * [countWin description]
     * @param  [type] $id [description]
     * @return [type]     [number of win time]
     */
    function countNumberTotalGame($id)
    {
        $MC = $this->db->where('USER_ID', $id)->from('MULTI_CHOICE_GAME_LOGS')->count_all_results();
        $YN = $this->db->where('USER_ID', $id)->from('YN_GAME_LOGS')->count_all_results();
        return ($MC + $YN);
    }

    /**
     * [getChampionNo description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function getChampionNo($id) {
        return $this->db->where('USER_ID', $id)->from('ACHIEVEMENT')->count_all_results();
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */