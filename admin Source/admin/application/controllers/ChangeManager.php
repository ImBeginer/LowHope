<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangeManager extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('ChangeManagerModel');
       
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

            $data['active_manager'] = $this->ChangeManagerModel->getActiveManager();
            $data['deactive_manager'] = $this->ChangeManagerModel->getDeactiveManager();
            $data['userName'] = $user_name;
            $data['userId'] = $user_id;
            $this->load->view('ChangeManager', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }    

    /**
     * [blockManager description]
     * @return [type] [description]
     */
    function blockManager()
     {
         $id = $this->input->post('id');
         $result = $this->ChangeManagerModel->blockManager($id);
         if ($result) {
            echo json_encode(1);
         } else {
            echo json_encode(0);
         }
     } 

     /**
      * [unblockManager description]
      * @return [type] [description]
      */
     function unblockManager()
     {
         $id = $this->input->post('id');
         $result = $this->ChangeManagerModel->unblockManager($id);
         if ($result) {
            echo json_encode(1);
         } else {
            echo json_encode(0);
         }
     } 
}



