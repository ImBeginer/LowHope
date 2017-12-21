<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class GameDetail extends CI_Controller {

    public $pusher;

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('GameDetailModel');
    }

    /**
     * 
     * @return [type] [description]
     */
    public function index()
    {
        /**
         * CHECK LOGGEDIN 
         * LOGGEDIN -> LOAD DATA
         * HAVE NOT LOGIN YET -> LOAD HOME
         */
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == true) {
            
            $game_type = $this->uri->segment(3);
            $game_id = $this->uri->segment(4);

            $game_info = $this->GameDetailModel->getGameDetail($game_type, $game_id);
            if ($game_info == false) {
                echo "<h1 style='text-align: center;'>KHÔNG CÓ DỮ LIỆU HIỂN THỊ</h1>";
                die();
            }
            $game_name = $game_info->TITLE;
            $player_count = $game_info->PLAYER_COUNT;
            $total_amount = $game_info->TOTAL_AMOUNT;
            $active = $game_info->ACTIVE;

            $owner = $game_info->OWNER_ID;
            $ownerName = $this->GameDetailModel->getOwner($owner)->USER_NAME;
            //get owner
            $created_date = $game_info->START_DATE;
            $end_date = $game_info->END_DATE;
            $user = $this->session->userdata('user');   
            $user_name = $user['USER_NAME'];

            $role_id = $user['ROLE_ID'];
            $data['role_id'] = $role_id;
            

            //create data object to sent to view
            $data['userName'] = $user_name;
            $data['game_id'] = $game_id;
            $data['game_type'] = $game_type;
            $data['game_name'] = $game_name;
            $data['player_count'] = $player_count;
            $data['total_amount'] = $total_amount;
            $data['active'] = $active;
            $data['owner'] = $ownerName;
            $data['created_date'] = $created_date;
            $data['end_date'] = $end_date;
            ($game_type == 'YN') ? ($data['type'] = 'Yes/No') : ($data['type'] = 'Multichoice');

            $user_list = $this->GameDetailModel->getJoinerList($game_type, $game_id);
            if ($user_list == false) {
                $user_list = [];
            }

            $data['userList'] = $user_list;   
             //send data to view
            $this->load->view('GameDetail', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     

    /**
     * [sentPusherNoti sent info to pusher]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function sentPusherNoti($data) {
        try {
            $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
             );
        $this->pusher = new Pusher\Pusher(
            'efd4e401d751e081f0f0',
            '3e978574da9ec9e3dbfb',
            '415653',
            $options
          );
        
        $query = $this->pusher->trigger('create_noti_channel', 'create_noti_event', $data);
        if ($query == true) {
            return true;
        } else {
            return false;
        }
        } catch (Exception $e) {
            return false;
        }
    }   


    function checkPermission() {
        try {

            $game_id = $this->input->post("game_id");
            $game_type = $this->input->post("game_type");
            $email = $this->input->post("email");
            $password = $this->input->post("password");
            $pass = $this->GameDetailModel->getPassword($email)->PASSWORD;
            $password = md5($password);
            // check perrmission
            if (hash_equals($pass, $password)) {
                // get all player join this game
                // pay back money
                $user_list = $this->GameDetailModel->getJoinerList($game_type, $game_id);
                if ($user_list == false) {
                    echo json_encode(1);
                    return;
                } else {
                    $lUserId = array();
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date('Y-m-d H:i:s', time());
                    foreach ($user_list as $user) {
                        array_push($lUserId, $user['USER_ID']);
                        $MONEY = 10;
                        $check = $this->GameDetailModel->payBack($user['USER_ID'], $MONEY);
                        if ($check) {
                            $this->GameDetailModel->closeGame($game_id, $game_type);
                            // insert noti
                            $checkSendNoti = $this->GameDetailModel->sentNoti($user['USER_ID'], $game_id, $game_type, $date);
                            if ($checkSendNoti) {
                            } else {
                                echo json_encode(2);
                            }
                        } else {
                            echo json_encode(2);
                        }
                    }
                    //sent noti
                    $type = 2;
                    if ($game_type == 'YN') {
                        $type = 1;
                    }
                    $data = $this->GameDetailModel->getDetailNoti($game_id, $lUserId, $type, $date);
                    $this->sentPusherNoti($data);
                    echo json_encode(1);
                }
            } else {
                echo json_encode(2);
            }
        } catch (Exception $e) {
            echo json_encode(0);
        }
    }

    function test()
    {
        $lUserId = array(4, 1);
        print_r($this->GameDetailModel->getDetailNoti(72, $lUserId, 1, '2017-12-06 16:30:01'));
    }
}



