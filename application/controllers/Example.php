<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller
{

	public function index()
	{
		// Load the library.
		// You can also autoload the library by adding it to config/autoload.php
		$this->load->library('ci_pusher');

		// Set message
		$data['message'] = 'This is message sent at ' . date('Y-m-d H:i:s');

		// Send message
		$event = $this->ci_pusher->trigger('test_channel', 'my_event', $data);

		var_dump($event);
	}
}
