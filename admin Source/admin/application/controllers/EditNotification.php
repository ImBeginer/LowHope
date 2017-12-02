<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EditNotification extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('EditNotificationModel');
    }

    /**
     * load first when login
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
            $data['noti_list'] = $this->EditNotificationModel->getDefaultNoti();
            $this->load->view('EditNotification', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     

}
