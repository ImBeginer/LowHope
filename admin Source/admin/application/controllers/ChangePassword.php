<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangePassword extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ChangePasswordModel');
       
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
            $data['role'] = $role_id;
            $this->load->view('ChangePassword', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }

    /**
     * [changePassword description]
     * @return [type] [description]
     */
    function changePassword()
    {
        $id = $this->input->post('id');
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass = $this->input->post('confirm_pass');

        $pass = $this->ChangePasswordModel->getOldPassword($id);
        $old_pass = md5($old_pass);

        if (hash_equals($pass, $old_pass)) {
            if ($new_pass === $confirm_pass) {
                $newpass = md5($new_pass);
                if ($this->ChangePasswordModel->updatePassword($id, $newpass)) {
                    echo json_encode(1);
                    return;
                }
            }
        }
        echo json_encode(0);

    }    
}



