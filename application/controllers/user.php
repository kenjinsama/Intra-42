<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
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
		$this->load->model('ticket');
		$data["tickets"] = $this->ticket->get_all_tickets();
		loader($this, 'user/tickets', $data);
	}

	public function create_tickets()
	{
		$data["title"] = array(
			  'name'        => 'title_ticket',
              'id'          => 'title_ticket'
		);
		loader($this, 'user/create_tickets', $data);
	}

	public function validate_tickets()
	{
		$this->form_validation->set_rules('title_ticket', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$ticket = array(
				'id_user' => $this->check_log->obtain_id(),
				'titre' => $this->input->post('title_ticket'),
				'content' => $this->input->post('description')
			);
			$this->load->model("ticket");
			$this->ticket->create_ticket($ticket);
			$this->tickets();
		}
		else
			$this->create_tickets();
	}

	public function see_ticket($id)
	{
		$this->load->model('ticket');
		$data['ticket'] = $this->ticket->get_ticket($id);
		$data['img_profile'] = $this->ldap->get_img($this->session->userdata('user_login'));
		loader($this, 'user/see_ticket', $data);
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
