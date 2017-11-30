<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CultureGame extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('CultureGameModel');
       
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
            $game_info = $this->CultureGameModel->getAllCultureGame();
            if ($game_info == false) {
                echo "<h1 style='text-align: center;'>KHÔNG CÓ DỮ LIỆU HIỂN THỊ</h1>";
                die();
            }
            $data['game_info'] = $game_info;
            //send data to view
            $this->load->view('CultureGame', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     

    function test()
    {
        print_r($this->CultureGameModel->getAllCultureGame());
    }
   
}


