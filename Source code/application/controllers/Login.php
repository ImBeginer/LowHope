<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   

        $this->output->delete_cache();
        $this->output->delete_cache(base_url());
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
        // //redirect to profile page if user already logged in
        // if($this->session->userdata('loggedInGooge') == true){
        //     redirect('login/user/');
        // }
        
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

        //load btc yesterday
        $date =  date('Y-m-d',strtotime("-1 days"));
        $time = $date.' 23:59:00';

        $data['price_yesterday'] = $this->game->getPriceYesterday($time);
        // $data['price_yesterday'] = '99999';

        //load btc current
        $data['price_current'] = $this->game->getPriceCurrent();

        //load all game
        $game = $this->game->getAllGameMini();

        if(isset($game['YN_ALL'])){
            $data['YN_ALL'] = $game['YN_ALL'];                            
            foreach ($data['YN_ALL'] as &$value) {
                $value = (object)$value;
                $value->TYPE = 'YN';
                $value = (array)$value;
            }
        }else{
            $data['YN_ALL'] = array(); 
        }

        if(isset($game['MUL_ALL'])){
            $data['MUL_ALL'] = $game['MUL_ALL'];                            
            foreach ($data['MUL_ALL'] as &$value) {
                $value = (object)$value;
                $value->TYPE = 'MUL';
                $value = (array)$value;
            }
        }else{
            $data['MUL_ALL'] = array();
        }

        if($game['YN_ACTIVE'] == 0 && $game['MUL_ACTIVE'] == 0){
            $data['ACTIVE'] = false;
        }else{
            $data['ACTIVE'] = true;
        }

        $data['all_game'] = array_merge($data['YN_ALL'], $data['MUL_ALL']);

        //load google login view
        $this->load->view('login/login_view',$data);
    }     

    /**
     * Kiểm tra user đã đăng nhập vào hệ thống chưa nếu chưa thì update thông tin
     * @return [type] [description]
     */
    public function user(){
        // redirect to login page if user not logged in
        if(!$this->session->userdata('loggedInGooge')){
            redirect('login/');
        }else {
            if($this->session->userdata('userGGExist')){
                try {
                    $user = $this->user->getUserByMail($this->session->userdata('userData')['USER_EMAIL']);
                    //check isPlayer                    
                    if($user->ROLE_ID == ROLE_USER){
                        $this->load_data_after_login_success($user);
                    }else{                        
                        $this->load->view('errors/error_page');
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
        $this->session->set_userdata('userGGExist', false);
        $this->session->unset_userdata('loggedInGooge');
        $this->session->unset_userdata('userGGExist');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('sessionUserId');
        $this->session->sess_destroy();        
        
        redirect(base_url().'login');
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
                $this->load_data_after_login_success($user);
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
        echo json_encode(1);
    }

    /************************** COMMON ***************************/
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
                    $CREATED_DATE = date("Y-m-d");

                    $USER_PHONE = str_replace('/[^0-9]/', '', $USER_PHONE);

                    $id = $this->user->addUser($USER_CIF,$USER_NAME,$USER_EMAIL,$USER_PHONE,$USER_ADDRESS,$CREATED_DATE);

                    if($id > 0){
                        
                        $user = $this->user->getUserByMail($USER_EMAIL);
                        $tt_game = $this->game->getGameTT();

                        //set sessionUserID
                        $this->session->set_userdata('sessionUserId', $id);
                        $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);
                        $this->session->set_userdata('userGGExist', true);

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

    public function load_data_after_login_success($user)
    {
        if($user->ATTENDANCE == 0){
            $this->user->updatePoint($user->USER_ID, $user->USER_POINT + REWARD_POINT);
            $is_update_attendance = $this->user->update_attendance($user->USER_ID);
            if($is_update_attendance){
                $data['is_reward'] = true;
            }
        }else{
            $data['is_reward'] = false;
        }

        $user = $this->user->getUserById($user->USER_ID);

        $tt_game = $this->game->getGameTT();

        
        $this->session->set_userdata('sessionUserId', $user->USER_ID);
        $this->session->set_userdata('session_Game_TT_ID', $tt_game->GAME_ID);
        
        //Đã đặt cược game truyền thống
        if($this->game->check_Log_Game_TT($user->USER_ID, $tt_game->GAME_ID)){
            $data['price_bet_before'] = $this->game->get_price_bet_before($user->USER_ID, $tt_game->GAME_ID);
        }
        
        $data['USER_NAME'] = $user->USER_NAME;
        $data['USER_POINT'] = $user->USER_POINT;
        $data['GAME_TT_CONTENT'] = $tt_game->CONTENT;
        $data['TT_END_DATE'] = $tt_game->END_DATE;

        $data['ALL_GAME_ACTIVE'] = $this->game->load_games_active();
        
        // list notification
        $data['noti'] = $this->user->get_all_noti_user($user->USER_ID);
        $data['user_id'] = $user->USER_ID;
        $data['top_point'] = $this->user->get_top_point();
        $data['is_related_YN'] = $this->user->is_related_YN($user->USER_ID);
        $data['is_related_MUL'] = $this->user->is_related_MUL($user->USER_ID);
        $data['top_users_achievement'] = $this->user->get_user_achievement_before();
        
        $this->load->view('user/home', $data);
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */