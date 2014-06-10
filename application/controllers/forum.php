<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Forum extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Forum_m');
	}

	function index()
	{
		$data['categories'] = $this->Forum_m->get_index();
		$data['urls'] = $this->Forum_m->format_urls(current_url());
		loader($this, 'forum/forum', $data);
	}

	function categories()
	{
		$ac = func_num_args();
		$name = func_get_args();
		$name = $name[$ac - 1];

		if ($name != "thread")
		{
			$this->form_validation->set_rules('title', '', 'required|callback_check_title');
			$this->form_validation->set_rules('message', '', 'required|callback_check_message');
			if ($this->form_validation->run())
			{		
				$data = array(
					'title' => $_POST['title'],
					'content' => $this->forum_l->formatPost($_POST['message']),
					'id_category' => $this->Forum_m->get_categorie_id($name),
					'id_user' => $this->session->userdata('user_id')
				);
				if (isset($_POST['visibility']))
					$data['visibility'] = $_POST['visibility'];
				$this->db->insert('posts', $data);
			}
			$data['categories'] = $this->Forum_m->get_categories_for($name);
			$data['posts'] = $this->Forum_m->get_posts_for($name);
		}
		else if (isset($_GET['id']))
		{
			$this->form_validation->set_rules('message', '', 'required|callback_check_message');
			if ($this->form_validation->run())
			{		
				$data = array(
					'content' => $this->forum_l->formatPost($_POST['message']),
					'id_post' => $_GET['id'],
					'id_user' => $this->session->userdata('user_id')
				);
				if (isset($_POST['visibility']))
					$data['visibility'] = $_POST['visibility'];
				$this->db->insert('answer', $data);
			}
			$data['thread'] = $this->Forum_m->get_thread($_GET['id']);
			$data['answers'] = $this->Forum_m->get_answers($_GET['id']);
		}

		$data['urls'] = $this->Forum_m->format_urls(current_url());
		loader($this, 'forum/forum', $data);
	}

	function check_title()
	{
		if (empty($_POST['title']))
			return (false);
		if (preg_match('/^[a-zA-Z -_.]*$/', $_POST['title']))
			return (true);
		else
		{
			$this->form_validation->set_message('check_title', 'Bad title format.');
			return (false);
		}
	}

	function check_message()
	{
		if (isset($_POST['message']) && $this->forum_l->formatPost($_POST['message']) != false)
			return (true);
		$this->form_validation->set_message('check_message', 'Message is too long.');
		return (false);
	}
}
?>