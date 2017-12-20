<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class AscendInRank extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('AscendInRankModel');
       
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
            $data['manager'] = $this->AscendInRankModel->getAllManager();
            $data['user'] = $this->AscendInRankModel->getAllUserOderByPoint();

            $data['userName'] = $user_name;
            $data['userId'] = $user_id;

            $this->load->view('AscendInRank', $data);
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
        $check = $this->AscendInRankModel->updateManager($id);
        if ($check) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }    
}



