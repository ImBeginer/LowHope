<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EditManagerInfo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('EditManagerModel');
       
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

            $user_detail = $this->EditManagerModel->getInfoById($user_id);
            $user_phone = $user_detail->PHONE_NUMBER;
            $user_address = $user_detail->ADDRESS;
            $user_email = $user_detail->EMAIL;
            
            $data['userName'] = $user_name;
            $data['userId'] = $user_id;
            $data['user_phone'] = $user_phone;
            $data['user_address'] = $user_address;
            $data['user_email'] = $user_email;

            $this->load->view('EditManagerInfo', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     

    /**
     * [updateInfo description]
     * @return [type] [1 - true or 0 - false]
     */
    function updateInfo()
    {
        $id = $this->input->post('id');
        $user_name = $this->input->post('userName');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        if ($this->EditManagerModel->updateUserInfo($id, $user_name, $phone, $address)) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    function test()
    {
        print_r($this->EditManagerModel->getInfoById(3)->PHONE_NUMBER);
        print_r($this->EditManagerModel->getInfoById(3)->ADDRESS);
        print_r($this->EditManagerModel->getInfoById(3)->EMAIL);
    }
   
}



