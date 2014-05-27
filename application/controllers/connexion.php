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

}
