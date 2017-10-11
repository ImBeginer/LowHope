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
		$data['prices'] = $this->user->getData();
		$this->load->view('user/testListen', $data);
	}
 
	public function testPusher()
	{
		$data['p'] = array('datee'=> 1507608120000, 'price' => 4.7);
  		$this->pusher->trigger('my-channel', 'my-event', $data);
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */