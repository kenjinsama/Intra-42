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
		$this->load->view('forum/forum', $data);
	}

	function categories()
	{
		$ac = func_num_args();
		$name = func_get_args();
		$name = $name[$ac - 1];

		$data['categories'] = $this->Forum_m->get_categories_for($name);
		$this->load->view('forum/forum', $data);
	}
}
?>