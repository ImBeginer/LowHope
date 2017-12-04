<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangeGift extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ChangeGiftModel');
       
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
            $data['userName'] = $user_name;
            $data['userId'] = $user_id;

            $data['lNoti'] = $this->ChangeGiftModel->getDefaultNoti();

            $this->load->view('ChangeGift', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }    
}



