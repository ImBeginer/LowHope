<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class GameDetail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('GameDetailModel');
       
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
            
            $game_type = $this->uri->segment(3);
            $game_id = $this->uri->segment(4);

            $game_info = $this->GameDetailModel->getGameDetail($game_type, $game_id);
            if ($game_info == false) {
                echo "<h1 style='text-align: center;'>KHÔNG CÓ DỮ LIỆU HIỂN THỊ</h1>";
                die();
            }
            $game_name = $game_info->TITLE;
            $player_count = $game_info->PLAYER_COUNT;
            $total_amount = $game_info->TOTAL_AMOUNT;
            $active = $game_info->ACTIVE;

            $owner = $game_info->OWNER_ID;
            $ownerName = $this->GameDetailModel->getNameOwner($owner);
            //get owner
            $created_date = $game_info->START_DATE;
            $end_date = $game_info->END_DATE;

            //create data object to sent to view
            $data['game_name'] = $game_name;
            $data['player_count'] = $player_count;
            $data['total_amount'] = $total_amount;
            $data['active'] = $active;
            $data['owner'] = $ownerName;
            $data['created_date'] = $created_date;
            $data['end_date'] = $end_date;
            ($game_type == 'YN') ? ($data['type'] = 'Multichoice') : ($data['type'] = 'Yes/No');

            $user_list = $this->GameDetailModel->getJoinerList($game_type, $game_id);
            if ($user_list == false) {
                $user_list = [];
            }

            $data['userList'] = $user_list;   
             //send data to view
            $this->load->view('GameDetail', $data);
        } else {
            redirect(base_url().'Login','refresh');
        }
    }     
   
}


