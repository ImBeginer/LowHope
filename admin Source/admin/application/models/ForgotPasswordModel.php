<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordModel extends CI_Model {

    function checkRole($email)
    {
        $result = $this->db->select("*")->from("USERS")->where("ROLE_ID", 1)->or_where("ROLE_ID", 2)->get()->row();
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
		$this->db->update('USERS', $data); 
		if ($this->db->affected_rows() > 0)
		{
		  return true;
		}
		else
		{
		  return false;
        }
    }
}