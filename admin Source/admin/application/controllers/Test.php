<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   

       
    }

    /**
     * load first when login
     * @return [type] [description]
     */
    public function index()
    {

        // session_start();
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo "Welcome to the member's area, " . $_SESSION['username'] . "!";
        } else {
            echo "Please log in first to see this page.";
        }

    }     



}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */