<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class connexion extends CI_Controller
{
	public function index()
	{
		$this->load->view("connexion");
	}

	public function		login()
	{
		$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if($this->form_validation->run() == TRUE)
		{
			if ($this->ldap->log($this->input->post('login'), $this->input->post('password')))
			{
				if ($this::db_check() == FALSE)
				{
					header("Location: " . base_url() . "connexion");
					return ;
				}
				$session =		array(
									'user_login' => $this->input->post('login'),
									'logged_in' => TRUE,
									'admin_login' => FALSE
								);

				$this->session->set_userdata($session);
			}
		}
		header("Location: " . base_url());
	}

	public function		logout()
	{
		$session =		array(
							'logged_in' => FALSE
						);

		$this->session->set_userdata($session);
		$this->session->unset_userdata("user_login");
		$this->session->unset_userdata("admin_login");
		header("Location: " . base_url());
	}

	private function		db_check()
	{
		$query = $this->db->query("SELECT `status` FROM `users` WHERE `login` LIKE ?", [$this->input->post('login')]);

		$query = $query->result_array();
		if (isset($query[0]["status"]))
		{
			if ($query[0]["status"] == "CLOSE")
				return FALSE;
		}
		else
		{
			$uid = $this->input->post('login');
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

}
