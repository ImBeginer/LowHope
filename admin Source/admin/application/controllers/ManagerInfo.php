<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerInfo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ManagerModel');
       
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

            $user_detail = $this->ManagerModel->getInfoById($user_id);
            $user_phone = $user_detail->PHONE_NUMBER;
            $user_address = $user_detail->ADDRESS;
            $user_email = $user_detail->EMAIL;
            $user_created_date = $user_detail->CREATE_DATE;
            
            $data['user_name'] = $user_name;
            $data['user_id'] = $user_id;
            $data['user_phone'] = $user_phone;
            $data['user_address'] = $user_address;
            $data['user_email'] = $user_email;
            $data['user_created_date'] = $user_created_date;

            $this->load->view('ManagerInfo', $data);
        } else {
            redirect(base_url().'/Login','refresh');
        }
    }     
}



