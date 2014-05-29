<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('modules_m');
		$data['modules'] = $this->modules_m->get_modules();
		loader($this, 'user/modules_list', $data);
	}

	public function projects($name)
	{
		$this->load->model('modules_m');
		$data['projects'] = $this->modules_m->get_projects($name);
		loader($this, 'user/projects_list', $data);
	}

	public function project($name)
	{
		$this->load->model('modules_m');
		$data['project'] = $this->modules_m->get_project($name);
		loader($this, 'user/project', $data);
	}
}