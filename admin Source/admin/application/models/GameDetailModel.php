<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameDetailModel extends CI_Model {

    /**
     * [getGameDetail description]
     * @param  [type] $id   [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    function getGameDetail($type,$id)
    {
        $this->db->select('*');
        if ($type == "YN") {
            $this->db->from('YN_GAMES');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->row();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else if ($type == "MC") {
            $this->db->from('MULTI_CHOICE_GAMES');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->row();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * [getNameOwner description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    function getOwner($id)
    {
        $this->db->select('*')->from('USERS')->where('USER_ID', $id);
        $result = $this->db->get()->row();
        return ($result);
    }

    /**
     * [getJoinerList description]
     * @param  [type] $type [game type - YN or MC]
     * @param  [type] $id   [game id]
     * @return [type]       [list of user join in this game]
     */
    function getJoinerList($type, $id)
    {
         $this->db->select('*');
        if ($type == "YN") {
            $this->db->from('YN_GAME_LOGS');
            $this->db->join('USERS', 'USERS.USER_ID = YN_GAME_LOGS.USER_ID');
            // $query = $this->db->get();
            // $this->db->from('YN_GAMES_LOGS');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->result_array();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else if ($type == "MC") {
            $this->db->from('MULTI_CHOICE_GAME_LOGS');
            $this->db->join('USERS', 'USERS.USER_ID = MULTI_CHOICE_GAME_LOGS.USER_ID');
            // $this->db->from('MULTI_CHOICE_GAMES_LOGS');
            $this->db->where('GAME_ID', $id);
            $result = $this->db->get()->result_array();
            if (count($result) > 0) {
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }

        /**
     * [getPassword description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    function getPassword($email)
    {
        return $this->db->select('*')->from('USERS')->where('EMAIL', $email)->get()->row();
    }

    /**
     * [payBack description]
     * @param  [type] $user_id [description]
     * @param  [type] $money   [description]
     * @return [type]          [true to update success or false]
     */
    function payBack($user_id, $money) {
        $user = $this->getOwner($user_id);
        $user_point = $user->USER_POINT;
        $new_point = $user_point + $money;
        $data = array(
           'USER_POINT' => $new_point
        );

        $this->db->where('USER_ID', $user_id);
        $result = $this->db->update('USERS', $data); 
        if ($result) {
            return true;
        }
        return false;
    }

    function sentNoti($user_id, $game_id, $game_type)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s', time());
        $type = 2;
        if ($game_type == 'YN') {
            $type = 1;
        }
        $data = array(
            'NOTICE_ID' => 9,
            'USER_ID' => $user_id ,
            'GAME_ID' => $game_id ,
            'TYPE_ID' => $type,
            'SEND_DATE' => $date,
            'SEEN' => 0
        );

        $this->db->insert('NOTIFICATION_DETAILS', $data); 
        $check = $this->db->affected_rows();
        if ($check > 0) {
            return true;
        }
        return false;
    }

    /**
     * [getDetailNoti description]
     * @param  [type] $noti_id [description]
     * @return [type]          [description]
     */
    public function getDetailNoti($game_id, $lUserId, $game_type)
    {
        $this->db->select('*');
        $this->db->from('NOTIFICATION_DETAILS');
        $this->db->join('NOTIFICATION', 'NOTIFICATION.NOTICE_ID = NOTIFICATION_DETAILS.NOTICE_ID');
        $this->db->join('USERS', 'USERS.USER_ID = NOTIFICATION_DETAILS.USER_ID');
        $this->db->where('NOTIFICATION_DETAILS.GAME_ID', $game_id);
        $this->db->where('NOTIFICATION_DETAILS.TYPE_ID', $game_type);
        $this->db->where_in('NOTIFICATION_DETAILS.USER_ID', $lUserId);
        return ($this->db->get()->result_array());
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */