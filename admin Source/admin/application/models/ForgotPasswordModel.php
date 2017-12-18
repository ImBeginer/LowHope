<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordModel extends CI_Model {

    function checkRole($email)
    {
        $query = "select * from USERS where EMAIL = ".$this->db->escape($email)." and  (ROLE_ID = 1 or ROLE_ID = 2)";
        $result = $this->db->query($query)->row();
        // $result = $this->db->select("*")->from("USERS")->where("ROLE_ID", 1)->or_where("ROLE_ID", 2)->get()->row();
        if (count($result) > 0) {
            return true;
        } 
        return false;
    }

    function updatePass($email, $pass)
    {
    	$data = array(
               'PASSWORD' => $pass
            );
		$this->db->where('EMAIL', $email);
		$result = $this->db->update('USERS', $data); 
		if ($result)
		{
		  return true;
		}
		else
		{
		  return false;
        }
    }
}