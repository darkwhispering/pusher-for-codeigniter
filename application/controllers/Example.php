<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller
{
	public function index()
	{
		$this->load->view('example');
	}

	public function trigger_event()
	{
		// Load the library.
		// You can also autoload the library by adding it to config/autoload.php
		$this->load->library('ci_pusher');

		$pusher = $this->ci_pusher->get_pusher();

		// Set message
		$data['message'] = 'This message was sent at ' . date('Y-m-d H:i:s');

		// Send message
		$event = $pusher->trigger('test_channel', 'my_event', $data);

		if ($event === TRUE)
		{
			echo 'Event triggered successfully!';
		}
		else
		{
			echo 'Ouch, something happend. Could not trigger event.';
		}
	}
}
