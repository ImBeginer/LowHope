<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class ChangeGift extends CI_Controller {

    public $pusher;
    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ChangeGiftModel');

        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $this->pusher = new Pusher\Pusher(
        '35555731a8560ac49e3b',
        'e6cb4dae14bbeda5149c',
        '429809',
        $options
        );
       
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

            $user = $this->session->userdata('user');   
            $user_name = $user['USER_NAME'];
            $user_id = $user['USER_ID'];
            $role_id = $user['ROLE_ID'];
            if ($role_id != 1) {
                redirect(base_url().'Login','refresh');
            }
            $avatar = $user['AVATAR'];
            $data['avatar'] = $avatar;
            $data['userName'] = $user_name;
            $data['userId'] = $user_id;

            $data['lNoti'] = $this->ChangeGiftModel->getDefaultNoti();

            $data['award'] = $this->ChangeGiftModel->getAward();

            $this->load->view('ChangeGift', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }

    function checkPermission()
    {
        try {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $pass = $this->ChangeGiftModel->getPassword($email)->PASSWORD;
            $password = md5($password);
            if (hash_equals($pass, $password)) {
                $win_1st = $this->input->post('win_1st');
                $win_2nd = $this->input->post('win_2nd');
                $win_3rd = $this->input->post('win_3rd');
                $noti_id = $this->input->post('noti_id');
                // deactive old award
                if ($this->ChangeGiftModel->updateActive()) {
                    // add new award
                    if ($this->ChangeGiftModel->insertAward($win_1st, $win_2nd, $win_3rd)) {
                        // add new noti to all member
                        if ($this->ChangeGiftModel->insertNotiToAll($noti_id)) {
                            echo json_encode(1);
                        } else {
                            echo json_encode(0);
                        }
                    } else {
                        echo json_encode(0);
                    }
                } else {
                    echo json_encode(0);
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
        $result = $this->ChangeGiftModel->getCurrentSystemGame();
        print_r($result);
    }
}



