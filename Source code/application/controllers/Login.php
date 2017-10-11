<?php 
defined('BASEPATH') OR exit('No direct script access allowed');



class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();        
        //load google login library
        $this->load->library('google');
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
            
            //check user if exist in DB -> redirect to choose screen
            
            //kiểm tra xem đã có email tồn tại trong hệ thống chưa
            $userGGExist = $this->user->checkGGUserExist($userGGData['USER_EMAIL']);            

            //store status & user info in session
            $this->session->set_userdata('loggedInGooge', true);
            $this->session->set_userdata('userGGExist', $userGGExist);
            $this->session->set_userdata('userData', $userGGData);
            
            //redirect to profile page
            redirect('login/user/');
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
            //get user info from session
            //$data['userGGData'] = $this->session->userdata('userGGData');
            //neu user ton tai roi thi chuyen sang man hinh chon loai choi
            if($this->session->userdata('userGGExist')){
                //load user profile view
                $user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
                $tt_game = $this->game->getGameTT();

                //set session for userID
                $this->session->set_userdata('sessionUserId', $user->USER_ID);
                $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

                $data['USER_NAME'] = $user->USER_NAME;
                $data['USER_POINT'] = $user->USER_POINT;
                $data['GAME_TT_CONTENT'] = $tt_game->GAME_CONTENT;
                $data['prices'] = $this->user->getData();
                
                $this->load->view('user/home', $data);
            }else{
                $this->load->view('user/updateUser');
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

    /*---------------------------------------  FACEBOOK  ---------------------------------------------------------*/
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

        $userFBExist = $this->user->checkUserFBExist($userFBData['USER_CIF']);
        $userFBChanged = $this->user->checkFBUserChanged($userFBData['USER_CIF'],$userFBData['USER_EMAIL']);

        //user khong ton tai
        if(!$userFBExist){
            echo json_encode("0");
        }else if($userFBExist && $userFBChanged){ //user ton tai va co su thay doi ve email or name
            //update lại người dùng facebook (dựa vào ID_Facebook), vì có thể họ đã thay đổi thông tin: email, tên hiển thị.
            $this->user->updateFBUser($userFBData['USER_CIF'],$userFBData['USER_NAME'],$userFBData['USER_EMAIL']);            
            echo json_encode("1");
        }else {
            echo json_encode("1");
        }
    }

    /**
     * [fb_AddUser description]
     * @return [type] [description]
     */
    public function fb_AddUser()
    {
        $this->load->view('user/updateUser');
    }

    /**
     * [fb_goHome description]
     * @return [type] [description]
     */
    public function fb_goHome()
    {
        $user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
        $tt_game = $this->game->getGameTT();

        //set sessionUserID
        $this->session->set_userdata('sessionUserId', $user->USER_ID);
        $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);

        $data['USER_NAME'] = $user->USER_NAME;
        $data['USER_POINT'] = $user->USER_POINT;
        $data['GAME_TT_CONTENT'] = $tt_game->GAME_CONTENT;
        $data['prices'] = $this->user->getData();

        $this->load->view('user/home', $data);
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

    public function test()
    {
        $this->load->view('user/testListen');
    }
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */