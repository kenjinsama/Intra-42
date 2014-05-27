<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller
{
	public function index()
	{
		$this->profile();
	}

	public function profile()
	{
		loader($this, 'user/profile');
	}

	public function tickets()
	{
		loader($this, 'user/tickets');
	}
}