<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CultureGame extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('CultureGameModel');
       
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
            $game_info = $this->CultureGameModel->getAllCultureGame();
            if ($game_info == false) {
                echo "<h1 style='text-align: center;'>KHÔNG CÓ DỮ LIỆU HIỂN THỊ</h1>";
                die();
            }
            $user = $this->session->userdata('user');   
            $avatar = $user['AVATAR'];
            $data['avatar'] = $avatar;
            $role_id = $user['ROLE_ID'];
            $data['role_id'] = $role_id;
            $user_name = $user['USER_NAME'];
            $data['userName'] = $user_name;
            $data['game_info'] = $game_info;
            //send data to view
            $this->load->view('CultureGame', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     
}


