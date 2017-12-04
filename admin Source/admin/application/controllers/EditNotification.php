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

            $user = $this->session->userdata('user');   
            
            $data['userName'] = $user['USER_NAME'];
            $this->load->view('EditNotification', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     

    /**
     * [updateNoti description]
     * @return [type] [1 - update successfull or 2 - update failed]
     */
    function updateNoti()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $content = $this->input->post('content');

        $result = $this->EditNotificationModel->updateNoti($id, $title, $content);    
        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    function deleteNoti()
    {
        $id = $this->input->post('id');
        $result = $this->EditNotificationModel->deleteNoti($id);
        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }
}
 