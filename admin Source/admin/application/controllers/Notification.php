<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH .'/vendor/autoload.php';
class Notification extends CI_Controller {

    public $pusher;

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('NotiModel');
       
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );
        $this->pusher = new Pusher\Pusher(
        '35555731a8560ac49e3b',
        'e6cb4dae14bbeda5149c',
        '429809',
        $options
        );

    }       


    /**
     *
     * @return [type] [description]
     */
    public function index()
    {

        /**
         * CHECK LOGGEDIN SESSION
         * LOGIN SUCCESS -> LOAD VIEW
         * LOGIN FAIL -> GO HOME
         */
        
            /**
             * GET DATA
             */
        if ($this->session->userdata('loggedIn') && $this->session->userdata('loggedIn') == true) {
            $data['lAllMember'] = $this->NotiModel->getAllMember();
            $data['lNewMember'] = $this->NotiModel->getNewMember();
            $data['lChampions'] = $this->NotiModel->getChampions();
            $data['lNoti'] = $this->NotiModel->getDefaultNoti();

            $user = $this->session->userdata('user');   
            $user_name = $user['USER_NAME'];
            $data['userName'] = $user_name;
            
            /**
             * SEND DATA TO VIEW
             */
            $this->load->view('notification', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }

    }     

     /**
     * [sentPusherNoti sent info to pusher]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function sentPusherNoti($data) {
        try {
            $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
             );
        $this->  $pusher = new Pusher\Pusher(
            'efd4e401d751e081f0f0',
            '3e978574da9ec9e3dbfb',
            '415653',
            $options
          );
        
        $query = $this->pusher->trigger('create_noti_channel', 'create_noti_event', $data);
        if ($query == true) {
            return true;
        } else {
            return fail;
        }
        } catch (Exception $e) {
            return false;
        }
    }   

    function test() {
        $query = $this->NotiModel->getInformationById(5);

        $total = $this->NotiModel->countNumberTotalGame(5);
        $win = $this->NotiModel->countWin(5);

        $query = (object) array_merge( (array)$query, array( 'TOTAL' => $total ) );
        $query = (object) array_merge( (array)$query, array( 'WIN' => $win ) );

        echo json_encode ($query);
    }

    /**
     *
     *
     */
    public function getInforById() {
        $id = $this->input->post('id');
        $query = $this->NotiModel->getInformationById($id);
        $total = $this->NotiModel->countNumberTotalGame($id);
        $win = $this->NotiModel->countWin($id);
        $champion = $this->NotiModel->getChampionNo($id);
        
        $query = (object) array_merge( (array)$query, array( 'TOTAL' => $total ) );
        $query = (object) array_merge( (array)$query, array( 'WIN' => $win ) );
        $query = (object) array_merge( (array)$query, array( 'CHAMPION' => $champion ) );

        echo json_encode ($query);


    }

    /**
     * [sentNotification description]
     * @return [type] [description]
     */
    public function sentNotification()
    {
        $lUserId = $this->input->post('userId');
        $contentId = $this->input->post('noticeId');
        $result = $this->NotiModel->sentNotification($lUserId, $contentId);

        if ($result == 1) {
            $content = $this->NotiModel->getNotiById($contentId);
            $this->sentPusherNoti($content);
        }

        // sent noti to pusher
        // userid, content, title, datetime
        // query === true => sent success
        // $query = $this->pusher->trigger('create_noti_channel', 'create_noti_event', $data);

        echo json_encode($result);
    }

    /**
     * [getDateTime description]
     * @return [type] [description]
     */
    public function getDateTime()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('m/d/Y h:i:s a', time());
        // $timezone = date_default_timezone_get();
        // echo "The current server timezone is: " . $timezone;
        print($date);
    }

    /**
     * [getNotiContent description]
     * @return [type] [description]
     */
    public function getNotiContent() 
    {
        $id = $this->input->post('id');
        $query = $this->NotiModel->getNotiById($id);
        echo json_encode ($query);
    }
}
