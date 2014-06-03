<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Connexion extends CI_Controller
{
	public function index()
	{
		if ($this->check_log->check_login() == FALSE)
			$this->load->view("connexion");
		else
			header("Location: " . base_url());
	}

	public function		login()
	{
		$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if($this->form_validation->run() == TRUE)
			$this::save_connection($this->input->post('login'), $this->input->post('password'));
		header("Location: " . base_url());
	}

	public function		logout()
	{
		$session =		array(
							'logged_in' => FALSE
						);

		$this->session->set_userdata($session);
		$this->session->unset_userdata("user_login");
		$this->session->unset_userdata("user_pass");
		$this->session->unset_userdata("admin_login");
		$this->session->unset_userdata("user_id");
		header("Location: " . base_url() . "connexion");
	}

	public function		autologin($key)
	{
		include(APPPATH . "config/config.php");
		$secret = base64_decode($key);
		$rand_string = substr($secret, 0, 5);
		$secret = substr($secret, 5);
		$secret = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $rand_string . $config['encryption_key'], $secret, MCRYPT_MODE_ECB);
		for ($i = 0; isset($secret[$i]) && $secret[$i] != '0'; $i++)
			;
		$login = substr($secret, 0, $i);
		for ($j = $i + 8; isset($secret[$j]) && $secret[$j] != "\0"; $j++)
			;
		$pass = substr($secret, $i + 8, $j - ($i + 8));
		$this::save_connection($login, $pass);
		header("Location: " . base_url());
	}

	private function		db_check($uid)
	{
		$query = $this->db->query("SELECT `status` FROM `users` WHERE `login` LIKE ?", [$uid]);

		$query = $query->result_array();
		if (isset($query[0]["status"]))
		{
			if ($query[0]["status"] == "CLOSE")
				return FALSE;
		}
		else
		{
			$this->db->query("INSERT INTO `users` (`login`, `cn`, `picture`, `status`) VALUES(?, ?, ?, ?)",
				array(
					$uid,
					$this->ldap->get_cn($uid),
					$this->ldap->get_img($uid),
					"STUDENT"
				)
			);

		}
		return TRUE;
	}

	private function	save_connection($login, $pass)
	{
		$this->load->model("check_log");
		if ($this->ldap->log($login, $pass))
		{
			if ($this::db_check($login) == FALSE)
			{
				header("Location: " . base_url() . "connexion");
				return ;
			}
			$id = $this->check_log->obtain_id($login);
			$admin = $this->check_log->is_admin($login);
			$session =		array(
								'user_login'	=> $login,
								'user_pass'		=> $pass,
								'user_id'		=> $id,
								'logged_in'		=> TRUE,
								'admin_login'	=> $admin
							);

			$this->session->set_userdata($session);
			$this->session->set_userdata(array("user_id" => $this->check_log->obtain_id($this->session->userdata("user_login"))));
		}
	}
}
