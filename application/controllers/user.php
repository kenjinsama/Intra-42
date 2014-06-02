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

}
