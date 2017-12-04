<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CultureGameDetail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('CultureGameDetailModel');
       
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
            $game_id = $this->uri->segment(3);

            $game_info = $this->CultureGameDetailModel->getGameDetail($game_id);
            if ($game_info == false) {
                echo "<h1 style='text-align: center;'>KHÔNG CÓ DỮ LIỆU HIỂN THỊ</h1>";
                die();
            }
            // get game info
            $game_name = $game_info->TITLE;
            $start_date = $game_info->START_DATE;
            $end_date = $game_info->END_DATE;
            $active = $game_info->ACTIVE;
            $result = -1;
            $user_champion_id = [];
            if ($active == 0) {
                $result = $game_info->RESULT;
                $champion = $this->CultureGameDetailModel->getChampion($game_id);
                while (1) {
                    foreach ($champion as $value) {
                        if ($value['AWARD_ID'] == 1) {
                            array_push($user_champion_id, $value['USER_ID']);
                        }
                    }
                    foreach ($champion as $value) {
                        if ($value['AWARD_ID'] == 2) {
                            array_push($user_champion_id, $value['USER_ID']);
                        }
                    }
                    foreach ($champion as $value) {
                        if ($value['AWARD_ID'] == 3) {
                            array_push($user_champion_id, $value['USER_ID']);
                        }
                    }
                }
            }

            //get game log info
            $player = $this->CultureGameDetailModel->getJoinerList($game_id);

            if ($player == false) {
                $player = [];
            }

            //create data object to sent to view
            $data['game_name'] = $game_name;
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
            $data['result'] = $result;
            $data['active'] = $active;

            $data['player'] = $player;

            $data['user_champion_id'] = $user_champion_id;

            //send data to view
            $this->load->view('CultureGameDetail', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
        
    }     

    function test()
    {
        $a = $this->CultureGameDetailModel->getJoinerList(2);
        foreach ($a as $value) {
            print_r($value['GAME_ID']);
        }
    }
   
}

