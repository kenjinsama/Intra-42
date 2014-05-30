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
		$this->load->model('projects_m');
		$data['projects'] = $this->projects_m->get_projects($name);
		loader($this, 'user/projects_list', $data);
	}

	public function project($name)
	{
		$this->load->model('projects_m');
		$data['project'] = $this->projects_m->get_project($name);
		loader($this, 'user/project', $data);
	}

	public function project_register()
	{
		$this->load->model('projects_m');
		$this->load->model('check_log');
		$this->db->query("INSERT INTO `user_projects` (`user_id`, `project_id`, `state`) VALUES(?,?,?)",
			array(
				'user_id' => $this->check_log->obtain_id(),
				'project_id' => $this->input->get('id'),
				'state' => 'REGISTERED'
			));
		redirect(base_url().'module/project/'.$this->input->get('name'));
	}
}