<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   

        //load google login library
        $this->load->library('google');

        //load model
        $this->load->model('user');
        $this->load->model('game');
    }

    /**
     * load first when login
     * @return [type] [description]
     */
    public function index()
    {
        //redirect to profile page if user already logged in
        if($this->session->userdata('loggedInGooge') == true){
            redirect('login/user/');
        }
        
        if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            
            //get user info from google
            $gpInfo = $this->google->getUserInfo();
            
            //preparing data for database insertion
            $userGGData['USER_CIF']       = $gpInfo['id'];
            $userGGData['USER_NAME']      = $gpInfo['name'];
            $userGGData['USER_EMAIL']     = $gpInfo['email'];
            $userGGData['USER_LINK']      = !empty($gpInfo['link'])?$gpInfo['link']:'';
            $userGGData['USER_AVATAR']    = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
            
            try {
                //kiểm tra xem đã có email tồn tại trong hệ thống chưa
                $userGGExist = $this->user->checkUserExist($userGGData['USER_EMAIL']);            

                //store status & user info in session
                $this->session->set_userdata('loggedInGooge', true);
                $this->session->set_userdata('userGGExist', $userGGExist);
                $this->session->set_userdata('userData', $userGGData);
                
                //redirect to profile page
                redirect('login/user/');
                
            } catch (Exception $e) {
                log_message('error',$e->getMessage());
                $this->load->view('errors/error_page');
            }
        }
        
        //google login url
        $data['loginURL'] = $this->google->loginURL();     
        //load google login view
        $this->load->view('login/login_view',$data);
    }     

    /**
     * Kiểm tra user đã đăng nhập vào hệ thống chưa nếu chưa thì update thông tin
     * @return [type] [description]
     */
    public function user(){
        //redirect to login page if user not logged in
        if(!$this->session->userdata('loggedInGooge')){
            redirect('login/');
        }else {
            if($this->session->userdata('userGGExist')){
                try {
                    $user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
                    //check isPlayer
                    if($user->ROLE_ID == ROLE_USER){
                        //load user home page
                        $tt_game = $this->game->getGameTT();
                        //set session for userID
                        $this->session->set_userdata('sessionUserId', $user->USER_ID);
                        $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

                        $data['USER_NAME'] = $user->USER_NAME;
                        $data['USER_POINT'] = $user->USER_POINT;
                        $data['GAME_TT_CONTENT'] = $tt_game->CONTENT;
                        $data['TT_END_DATE'] = $tt_game->END_DATE;

                        //$data['prices'] = $this->user->getData();
                        
                        $this->load->view('user/home', $data);
                    }else{
                        redirect(base_url());
                    }
                    
                } catch (Exception $e) {
                    log_message('error',$e->getMessage());
                    $this->load->view('errors/error_page');
                }
            }else{
                //add new user
                $this->load->view('user/addUser');
            } 
        }        
    }

    /**
     * logout user ra khoi he thong
     * @return [type] [description]
     */
    public function logoutGoogle(){
        //delete login status & user info from session
        $this->session->set_userdata('loggedInGooge', false);
        $this->session->unset_userdata('loggedInGooge');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('sessionUserId');
        $this->session->sess_destroy();        
        
        redirect(base_url());
    }

    /*--------------------------  FACEBOOK  -----------------------------------*/
    /**
     * [fb_CheckUserExist description]
     * @return [type] [description]
     */
    public function fb_CheckUserExist()
    {
        //set session logged by fb
        $this->session->set_userdata('loggedInFB', true);
        
        $userFBData['USER_CIF'] = $this->input->post('fb_id');
        $userFBData['USER_NAME'] = $this->input->post('fb_name');
        $userFBData['USER_EMAIL'] = $this->input->post('fb_email');
        $userFBData['USER_LINK'] = $this->input->post('fb_link');
        $userFBData['USER_AVATAR'] = $this->input->post('fb_avatar');

        $this->session->set_userdata('userData', $userFBData);
        try {
            // kiem tra email fb co trung voi email nao ko
            $userFBExist = $this->user->checkUserExist($userFBData['USER_EMAIL']);
            if($userFBExist){                
                //truong hop trung email 
                //go home
                echo json_encode(1);
            }else{ //neu khong trung email
                //kiem tra xem nick fb co thay doi gi ko
                $userFBChanged = $this->user->checkFBUserChanged($userFBData['USER_CIF']);
                if($userFBChanged){
                    //truong hop email có bị thay đổi do CIF không thay đổi đc
                    // update lại user fb này
                    $this->user->updateFBUser($userFBData['USER_CIF'],$userFBData['USER_NAME'],$userFBData['USER_EMAIL']);
                    //go home
                    echo json_encode(1);
                }else{
                    //add new 
                    echo json_encode(0);
                }
            }            
        } catch (Exception $e) {
            log_message('error',$e->getMessage());
            $this->load->view('errors/error_page');
        }
    }

    /**
     * [fb_AddUser description]
     * @return [type] [description]
     */
    public function fb_AddUser()
    {        
        $this->load->view('user/addUser');       
    }

    /**
     * [fb_goHome description]
     * @return [type] [description]
     */
    public function fb_goHome()
    {
        try {
            $user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
            if($user->ROLE_ID == ROLE_USER){            
                $tt_game = $this->game->getGameTT();
                  
                //set sessionUserID
                $this->session->set_userdata('sessionUserId', $user->USER_ID);
                $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

                $data['USER_NAME'] = $user->USER_NAME;
                $data['USER_POINT'] = $user->USER_POINT;
                $data['GAME_TT_CONTENT'] = $tt_game->CONTENT;
                $data['TT_END_DATE'] = $tt_game->END_DATE;
                
                //$data['prices'] = $this->user->getData();

                $this->load->view('user/home', $data);
            }else{
                redirect(base_url());
            }            
        } catch (Exception $e) {
            log_message('error',$e->getMessage());
            $this->load->view('errors/error_page');
        }             
    }   
    
    /**
     * [fb_Logout description]
     * @return [type] [description]
     */
    public function fb_Logout()
    {
        $this->session->set_userdata('loggedInFB', false);
        $this->session->unset_userdata('loggedInFB');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('sessionUserId');
        $this->session->sess_destroy();
    }

    /************************** ***************************/
    public function addUser()
    {
        if(isset($_POST['USER_NAME']) && isset($_POST['USER_PHONE']) && isset($_POST['USER_ADDRESS'])){
            $USER_CIF = $this->session->userdata('userData')['USER_CIF'];
            $USER_EMAIL = $this->session->userdata('userData')['USER_EMAIL'];

            try {
                if(!$this->user->checkUserExistPlus($USER_CIF,$USER_EMAIL)){

                    $USER_NAME = $this->input->post('USER_NAME');
                    $USER_PHONE = $this->input->post('USER_PHONE');
                    $USER_ADDRESS = $this->input->post('USER_ADDRESS');

                    $USER_PHONE = str_replace('/[^0-9]/', '', $USER_PHONE);

                    $id = $this->user->addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS);

                    if($id > 0){
                        
                        $user = $this->user->getUserByMail($USER_EMAIL);
                        $tt_game = $this->game->getGameTT();

                        //set sessionUserID
                        $this->session->set_userdata('sessionUserId', $id);
                        $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

                        echo json_encode(1);
                    }
                }else {
                    echo json_encode(0);
                }                
            } catch (Exception $e) {
                log_message('error',$e->getMessage());
                $this->load->view('errors/error_page');
            }
        }else{
            echo json_encode(0);
        }
    }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */