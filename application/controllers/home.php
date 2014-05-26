<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			header("Location: " . base_url() . "install/");
		$this->load->view('home');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
