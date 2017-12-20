<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('LoginModel');
    }

    /**
     * load first when login
     * @return [type] [description]
     */
    public function index()
    {
        /**
         * CHECK LOGGEDIN SESSION
         */
        
        $data = [];
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == true) {
            // $data['checkLogin'] = 1;
            redirect(base_url().'Home','refresh');
        } else {
            // $data['checkLogin'] = 0;
            $this->load->view('Login', $data);
        }
        
    }     

    /**
     * [logIn description]
     * @return [type]        [description]
     */
    public function logIn ()
    {
        // $email = 'tranhongquan.94@gmail.com';
        // $pass = '123@abcA';
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');

        //encryption password 123@abcA
        // $password = password_hash('123@abcA', PASSWORD_DEFAULT);
        $password = md5($pass);
        $result = $this->LoginModel->checkLogin($email, $password);
        if (!$result) {
            echo json_encode(0);
        } else {
            // check login success!
            $user['USER_ID'] = $result->USER_ID;
            $user['USER_NAME'] = $result->USER_NAME;
            $user['ROLE_ID'] = $result->ROLE_ID;
            $user['EMAIL'] = $result->EMAIL;
            $user['AVATAR'] = $result->AVATAR;

            $this->session->set_userdata('loggedIn', true);
            $this->session->set_userdata('user', $user);
            echo json_encode(1);
        }
    }

    /**
     * [logOut check to log out]
     * @return [type] [description]
     */
    public function logOut()
    {
        $this->session->set_userdata('loggedIn', false);
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
        $this->index();
    }



}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
