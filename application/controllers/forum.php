<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
			$this->form_validation->set_rules('title', '', 'requiered');
			$this->form_validation->set_rules('message', '', 'requiered');
			if ($this->form_validation->run())
			{

			}
			$data['categories'] = $this->Forum_m->get_categories_for($name);
			$data['posts'] = $this->Forum_m->get_posts_for($name);
		}
		else if (isset($_GET['id']))
		{
			$data['thread'] = $this->Forum_m->get_thread($_GET['id']);
		}

		$data['urls'] = $this->Forum_m->format_urls(current_url());
		loader($this, 'forum/forum', $data);
	}
}
?>