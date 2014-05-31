<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller
{
	public function index()
	{
		$this->profile();
	}

	public function profile($generate = NULL)
	{
		if ($generate == "generate")
		{
			$data["generate"] = $this->generate();
			loader($this, 'user/profile', $data);
		}
		else
			loader($this, 'user/profile');

	}

	public function tickets()
	{
		loader($this, 'user/tickets');
	}

	public function generate()
	{
		$random_string = "";
		include(APPPATH . "config/config.php");
		for ($i = 0; $i < 5; $i++)
			$random_string = $random_string.chr(rand(33, 124));
		$secret = $this->session->userdata("user_login") . "00000000" . $this->session->userdata("user_pass");
		$key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $random_string . $config['encryption_key'], $secret, MCRYPT_MODE_ECB);
		return (base_url() . "connexion/autologin/" . base64_encode($random_string . $key));
	}
}
