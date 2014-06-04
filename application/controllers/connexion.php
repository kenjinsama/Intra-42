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
		$secret = base64_decode(strtr($key, '-_', '+/'));
		$rand_string = substr($secret, 0, 5);
		$secret = substr($secret, 5);
		$secret = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $rand_string . $config['encryption_key'], $secret, MCRYPT_MODE_ECB);
		for ($i = 0; isset($secret[$i]) && $secret[$i] != '0'; $i++)
			;
		$login = substr($secret, 0, $i);
		for ($j = 15; isset($secret[$j]) && $secret[$j] != "\0"; $j++)
			;
		$pass = substr($secret, 17, $j - 17);
		$this->save_connection($login, $pass);
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
			$this->load->model("update_bdd");
			define("DEFAULT_IMG","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");
			$this->update_bdd->load_user();
		}
	}
}
