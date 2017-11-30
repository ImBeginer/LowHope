<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('IndexModel');
       
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
            /**
             * GET DATA
             * @var [type]
             */
            $array = $this->IndexModel->getNumberEachMonth();
            $string = "";
            foreach ($array as $value) {
                $string .= $value.',';
            }
            // get quantity of member
            $data['allMember'] = $this->IndexModel->getNumberMember();

            $data['newMember'] = $this->IndexModel->getNumberMonthMember();

            $data['allSystemGame'] =  $this->IndexModel->getNumberSystemGame();

            $data['allYNGame'] =  $this->IndexModel->getNumberYNGame();

            $data['allMCGame'] =  $this->IndexModel->getNumberMCGame();

            $data['topPoint'] = $this->IndexModel->getMemberOderByPoint();

            $data['topYNGame'] = $this->IndexModel->getYNGame();

            $data['topMCGame'] = $this->IndexModel->getMCGame();

            $data['array'] = $string;
        
            /**
             * SEND DATA TO VIEW
             */
            $this->load->view('index', $data);
        } else {
            redirect(base_url().'index.php/Login','refresh');
        }
    }     
   
}