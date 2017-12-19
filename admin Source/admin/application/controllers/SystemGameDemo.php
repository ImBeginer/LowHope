<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class SystemGameDemo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('SystemGameDemoModel');
       
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
            $data['currentGame'] = $this->SystemGameDemoModel->getCurrentGame();

            $data['userName'] = $user_name;
            $data['userId'] = $user_id;

            $this->load->view('SystemGameDemo', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }

    /**
     * [changePermission description]
     * @return [type] [description]
     */
    function changePermission()
    {
        $id = $this->input->post('id');
        $sys_date = $this->input->post('date');
        $end_date = date('Y-m-d H:i:s', (double)$sys_date/1000);
        $check = $this->SystemGameDemoModel->updateSysGameTime($id, $end_date);
        if ($check) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }    
}



