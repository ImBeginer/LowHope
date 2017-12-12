<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    /**
     * [checkLogin description]
     * @param  [type] $email    [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
    public function checkLogin($email, $password)
    {
        // echo $password;
        // $this->db->select('*');
        // $this->db->from('USERS');
        // $this->db->where('EMAIL', $email);
        // $this->db->where('ROLE_ID', 1);
        // $this->db->or_where('ROLE_ID', 2);

        $query = "select * from USERS where EMAIL = ".$this->db->escape($email)." and  (ROLE_ID = 1 or ROLE_ID = 2)";
        $result = $this->db->query($query)->row();
        // $this->db->where('PASSWORD', $password);
        // $result = $this->db->get()->row();
        if (count($result) > 0 ) {
            $pass = ($result->PASSWORD);
            $compare = hash_equals($pass, $password);
            if ($compare) {
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }
}

/* End of file indexModel.php */
/* Location: ./application/models/indexModel.php */