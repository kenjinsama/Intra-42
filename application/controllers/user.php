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
		{
			$user_id = $this->check_log->obtain_id($user);
			$data['user'] = $this->ldap->get_user_info($user)[0];
		}
		else
		{
			$user_id = $this->session->userdata('user_id');
			$data['user'] = $this->ldap->get_user_info($this->session->userdata('user_login'))[0];
		}
		$this->load->model('modules_m');
		$data['finished_modules'] = $this->modules_m->get_finished_modules_from_user($user_id);
		$data['current_modules'] = $this->modules_m->get_current_modules_from_user($user_id);
		$data['coming_modules'] = $this->modules_m->get_futures_modules();
		$array_c = $this->modules_m->get_validated_modules_from_user($user_id);
		$data['credits'] = $this->modules_m->get_total_credits_from_module($array_c);
		$array = $this->modules_m->get_modules_from_user($user_id);
		$data['total_credits'] = $this->modules_m->get_total_credits_from_module($array);
		loader($this, 'user/profile', $data);
	}

	public function add_admin($login)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());
		$this->db->query("UPDATE `users` SET `status` = 'ADMIN' WHERE `login` = ?", array($login));
		redirect(base_url() . "user/profile/" . $login);
	}

	public function add_modo($login)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());
		$this->db->query("UPDATE `users` SET `status` = 'MOD' WHERE `login` = ?", array($login));
		redirect(base_url() . "user/profile/" . $login);
	}

	public function suppr_admin($login)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());
		$this->db->query("UPDATE `users` SET `status` = 'STUDENT' WHERE `login` = ?", array($login));
		redirect(base_url() . "user/profile/" . $login);
	}

	public function tickets()
	{
		$this->load->model('ticket');
		if (($data['isadmin'] = $this->check_log->check_log_admin()))
		{
			$data['assign'] = $this->ticket->get_assign_ticket();
			$data['no_assign'] = $this->ticket->get_non_assign_ticket();
		}
		$data['tickets'] = $this->ticket->get_my_tickets();
		loader($this, 'user/tickets', $data);
	}

	public function	add_comment()
	{
		$this->form_validation->set_rules('content', 'content', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$comment = array(
				"content" => $this->input->post("content"),
				"id_ticket" => $this->input->post("id"),
				"id_user" => $this->session->userdata("user_id")
			);
			$this->load->model('ticket');
			$this->ticket->create_comment($comment);
		}
		redirect(base_url() . "user/response_ticket/" . $this->input->post("id"));
	}

	public function create_tickets()
	{
		$this->load->model('ticket');
		$data['title'] = array(
				'name'			=> 'title_ticket',
				'id'			=> 'title_ticket'
		);
		$data['enums'] = $this->ticket->enum_select('tickets', 'type');
		$data['priorities'] = $this->ticket->enum_select('tickets', 'priority');
		loader($this, 'user/create_tickets', $data);
	}

	public function validate_tickets()
	{
		$this->form_validation->set_rules('title_ticket', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('priority', 'Priority', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$ticket = array(
				'title' => $this->input->post('title_ticket'),
				'type' => $this->input->post('type'),
				'priority' => $this->input->post('priority'),
				'content' => $this->input->post('description'),
				'id_user' => $this->session->userdata("user_id")
			);
			$this->load->model("ticket");
			$this->ticket->create_ticket($ticket);
			$this->tickets();
		}
		else
			redirect(base_url() . "user/tickets");
	}

	public function see_ticket($id)
	{
		$this->load->model('ticket');

		$data['ticket'] = $this->ticket->get_ticket($id);
		$data["id"] = $id;
		if ($data['ticket'])
			loader($this, 'user/see_ticket', $data);
	}

	public function response_ticket($id)
	{
		$query = $this->db->query("SELECT `title`, `state`, `type`, `content` FROM `tickets` WHERE `id` = ?", array($id));
		$data["tickets"] = $query->result_array();
		$query = $this->db->query("SELECT * FROM `comment_tickets` WHERE `id_ticket` = ?", array($id));
		$data["comment"] = $query->result_array();
		$data["id"] = $id;
		loader($this, 'user/response_ticket', $data);
	}

	public function yearbook($search = NULL)
	{
		loader($this, 'user/yearbook');
	}

	public function generate()
	{
		$random_string = "";
		include(APPPATH . "config/config.php");
		for ($i = 0; $i < 5; $i++)
			$random_string = $random_string.chr(rand(33, 124));
		$separator = "0";
		$this->db->set('key', $random_string);
		$this->db->where('login', $this->session->userdata("user_login"));
		$this->db->update('users');
		while (strlen($this->session->userdata("user_login") . $separator) <= 16)
			$separator = $separator . "0";
		$secret = $this->session->userdata("user_login") . $separator . $this->session->userdata("user_pass");
		$key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $random_string . $config['encryption_key'], $secret, MCRYPT_MODE_ECB);
		$data["generate"] = base_url() . "connexion/autologin/" . strtr(base64_encode($random_string . $key), '+/', '-_');
		$data['user'] = $this->ldap->get_user_info($this->session->userdata('user_login'))[0];
		/*
		**	On regénère les informations de la page avant de la recharger
		*/
		$this->load->model('modules_m');
		$data['finished_modules'] = $this->modules_m->get_finished_modules_from_user($this->session->userdata('user_id'));
		$data['current_modules'] = $this->modules_m->get_current_modules_from_user($this->session->userdata('user_id'));
		$array_c = $this->modules_m->get_validated_modules_from_user($this->session->userdata('user_id'));
		$data['credits'] = $this->modules_m->get_total_credits_from_module($array_c);
		$array = $this->modules_m->get_modules_from_user($this->session->userdata('user_id'));
		$data['total_credits'] = $this->modules_m->get_total_credits_from_module($array);

		loader($this, 'user/profile', $data);
	}

	function	assign_ticket($id)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());

		$this->form_validation->set_rules('uid', 'uid', 'trim|required|xss_clean');
		if ($this->form_validation->run() == TRUE)
		{
			if ($this->check_log->is_admin($this->input->post("uid")))
			{
				$this->db->query("UPDATE `tickets` SET `id_admin` = ? WHERE `id` = ?",
					array(
						$this->check_log->obtain_id($this->input->post("uid")),
						$id
						)
				);
			}
		}
		redirect(base_url() . "user/response-tickets/" . $id);
	}

	function	close_ticket($id)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());
		$this->db->query("UPDATE `tickets` SET `state` = 'CLOSE' WHERE `id` = ?", array($id));
		redirect(base_url(). "user/tickets");
	}

	function	open_ticket($id)
	{
		if (!$this->check_log->check_log_admin())
			redirect(base_url());
		$this->db->query("UPDATE `tickets` SET `state` = 'OPEN' WHERE `id` = ?", array($id));
		redirect(base_url(). "user/tickets");
	}
}
