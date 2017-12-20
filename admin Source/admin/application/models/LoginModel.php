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

        $query = "select * from USERS where EMAIL = ".$this->db->escape($email)." and  (ROLE_ID = 1 or ROLE_ID = 2) and (ACTIVE = 1)";
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