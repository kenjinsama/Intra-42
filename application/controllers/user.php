<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		$this->profile();
	}

	public function profile($user = NULL)
	{
		if ($user != NULL)
			$data['user'] = $this->ldap->get_user_info($user)[0];
		else
			$data['user'] = $this->ldap->get_user_info($this->session->userdata('user_login'))[0];
		loader($this, 'user/profile', $data);
	}

	public function tickets()
	{
		loader($this, 'user/tickets');
	}

	public function yearbook($search = NULL)
	{
		$data['users'] = $this->ldap->get_all();
		loader($this, 'user/yearbook', $data);
	}

	public function generate()
	{
		$random_string = "";
		include(APPPATH . "config/config.php");
		for ($i = 0; $i < 5; $i++)
			$random_string = $random_string.chr(rand(33, 124));
		$secret = $this->session->userdata("user_login") . "00000000" . $this->session->userdata("user_pass");
		$key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $random_string . $config['encryption_key'], $secret, MCRYPT_MODE_ECB);
		$data["generate"] = base_url() . "connexion/autologin/" . base64_encode($random_string . $key);
		$data['user'] = $this->ldap->get_user_info($this->session->userdata('user_login'))[0];
		loader($this, 'user/profile', $data);
	}
}
