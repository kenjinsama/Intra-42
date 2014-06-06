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

	public function group_register()
	{
		$this->load->model('projects_m');
		$data['project_id'] = $this->input->get('project_id');
		loader($this, 'user/group_register', $data);
	}

	public function project_register()
	{
		$this->load->model('projects_m');
		$this->load->model('check_log');
		$query = $this->db->query('SELECT `grp_size` FROM `projects` WHERE id="'.$this->input->get('id').'"');
		$res = $query->result();
		if ($res[0]->grp_size > 1)
		{
			redirect(base_url().'module/group_register?project_id='.$this->input->get('id'));
			return ;
		}
		$this->project_m->register_user($this->check_log->obtain_id(), $this->input->get('id'));
		redirect(base_url().'module/project/'.$this->input->get('name'));
	}

	public function validate($id_project, $users)
	{
		$users = explode("#->", $users);

		foreach ($users as $user)
			$this->db->query('UPDATE `user_projects` SET state = "REGISTERED" , id_master = "'.$this->session->userdata('user_id').'" WHERE user_id = "'.$this->check_log->obtain_id($user).'"');
		$this->db->query('UPDATE `user_projects` SET state = "REGISTERED" WHERE user_id = "'.$this->session->userdata('user_id').'"');
		redirect("/");
	}
}