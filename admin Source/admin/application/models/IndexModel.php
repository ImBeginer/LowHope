<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexModel extends CI_Model {

	/**
     * load first when login
     * @return number of members
     */
    public function getNumberMember()
    {
        return $this->db->count_all('USERS');
    } 

    /**
     * load first when login
     * @return number of new members
     */
    public function getNumberMonthMember()
    {
        $month = date('m', strtotime('first day of last month'));
        $this->db->select('COUNT(*) AS MMM');
        $this->db->from('USERS');
        $this->db->where('MONTH(CREATE_DATE)', $month); 
        $result = $this->db->get();
        $count = $result->row();
        return ($count->MMM);
    } 

    /**
     * load first when login
     * @return  number of system game
     */
    public function getNumberSystemGame() {
        return $this->db->count_all('SYSTEM_GAMES');
    }

    /**
     * load first when login
     * @return number of y/n game
     */
    public function getNumberYNGame() {
        return $this->db->count_all('YN_GAMES');
    }

    /**
     * load first when login
     * @return number of Multi choice game
     */
    public function getNumberMCGame() {
        return $this->db->count_all('MULTI_CHOICE_GAMES');
    }

    /**
     * load first when login
     * @return array include number of member each month
     */
    public function getNumberEachMonth()
    {
        $lMonth = array();
        $year = date("Y");
        $month = array(1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12);
        for ($i=0; $i < count($month); $i++) { 
            $this->db->select('COUNT(*)');
            $this->db->from('USERS');
            $this->db->where('MONTH(CREATE_DATE)', $month[$i]); 
            $this->db->where('YEAR(CREATE_DATE)', $year); 
            $result = $this->db->get()->row_array();
            $count = $result['COUNT(*)'];
            array_push($lMonth, $count);
        }
        // $data['lMonth'] = $lMonth;
        // print_r($lMonth);
        return $lMonth;
    } 

    /**
     * load first when login
     * @return list of top hight member's point
     */
    public function getMemberOderByPoint()
    {
    	$this->db->limit(10);
        $this->db->select('*');
        $this->db->from('USERS');
        $this->db->where('ROLE_ID', 3);
        $this->db->order_by("USER_POINT", "desc"); 
        $result = $this->db->get()->result_array();
        return ($result);
        // print_r($query[0]['USER_POINT']);  // 
        // print_r($query);

        // $this->db->select('(SELECT SUM(payments.amount) FROM payments WHERE payments.invoice_id=4) AS amount_paid', FALSE); 
        // $query = $this->db->get('mytable');
    } 

    /**
     * load first when login
     * @return list of top Yes No game
     */
    public function getYNGame()
    {
        // $this->db->limit(10);
        $this->db->select('*');
        $this->db->from('YN_GAMES');
        $this->db->order_by("GAME_ID", "desc"); 
        $result = $this->db->get()->result_array();
        return ($result);
    } 

    /**
     * load first when login
     * @return list of top Multiple Choice game
     */
    public function getMCGame()
    {
        // $this->db->limit(10);
        $this->db->select('*');
        $this->db->from('MULTI_CHOICE_GAMES');
        $this->db->order_by("GAME_ID", "desc"); 
        $result = $this->db->get()->result_array();
        return ($result);
    } 
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */