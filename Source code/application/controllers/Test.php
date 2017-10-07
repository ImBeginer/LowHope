<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . '/vendor/autoload.php';
class Test extends CI_Controller {
	public $pusher;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('user');
		$options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        ); 

        $this->pusher = new Pusher\Pusher(
            '711b956416d9d15de4b8',
            '806a478e4cde60531b0a',
            '409599',
            $options
        );
	}

	public function index()
	{
		$this->load->view('user/testListen');
	}

	public function getChange()
	{
		//$userId = $this->input->post('userId');
		//$data['users'] = $this->user->getAllUsers();
  		$this->pusher->trigger('my-channel', 'my-event', $data);
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */