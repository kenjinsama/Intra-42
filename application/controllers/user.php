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
		$this->load->model('modules_m');
		$array_c = $this->modules_m->get_validated_modules_from_user($this->session->userdata('user_id'));
		$data['credits'] = $this->modules_m->get_total_credits_from_module($array_c);
		$array = $this->modules_m->get_modules_from_user($this->session->userdata('user_id'));
		$data['total_credits'] = $this->modules_m->get_total_credits_from_module($array);
		loader($this, 'user/profile', $data);
	}

	public function tickets()
	{
		$this->load->model('ticket');
		$data['isadmin'] = $this->check_log->check_log_admin();
		if ($data['isadmin'])
			$data['tickets'] = $this->ticket->get_all_tickets('priority');
		else
			$data['tickets'] = $this->ticket->get_all_tickets();
		loader($this, 'user/tickets', $data);
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
				'priority' => $this->input->post('priority')
			);
			$comment = array(
				'id_user' => $this->check_log->obtain_id(),
				'content' => $this->input->post('description')
			);
			$this->load->model("ticket");
			$this->ticket->create_ticket($ticket, $comment);
			$this->tickets();
		}
		else
			$this->create_tickets();
	}

	public function see_ticket($id)
	{
		$this->load->model('ticket');
		// $this->load->library('table');

		$data['ticket'] = $this->ticket->get_ticket($id);

		// echo '<pre>',print_r($data['ticket'], 1),'</pre>';
		// $data['username'] = $this->session->userdata('user_login');
		// $cell_img = array(
		// 	'data' => '<img width="100" height="120" style="-webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;" src="data:image/jpeg;base64,'.$this->ldap->get_img($data['username']).'" alt="profile">',
		// 	'rowspan' => 2
		// );
		// $this->table->add_row($cell_img, 'Red', 'Green');
		// $this->table->add_row('Red', 'Green');
		// $data['table'] = $this->table->generate();
		if ($data['ticket'])
			loader($this, 'user/see_ticket', $data);
	}

	public function response_ticket($id)
	{
		$data['id'] = $id;
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
		loader($this, 'user/profile', $data);
	}
}
