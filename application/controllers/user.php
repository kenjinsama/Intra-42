<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller
{
	public function index()
	{
		$this->profile();
	}

	public function profile()
	{
		$this->load->view('user/profile');
	}

	public function tickets()
	{
		$this->load->view('user/tickets');
	}
}
