<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Admin extends CI_Controller
{
	public function		index()
	{
		if ($this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		loader($this, "admin/index");
	}


	/*
	**	PROJETS
	*/
	public function		add_project()
	{
		if ($this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->load->model('modules_m');
		$data['modules'] = $this->modules_m->get_modules();
		loader($this, 'admin/add_project', $data);
	}

	public function validate_project()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean|callback_check_name');
		$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_corr', 'End correction', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start_h', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_h', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc_h', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_corr_h', 'End correction', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module', 'module', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('pdf_url', 'pdf_url', 'trim|required|xss_clean');
		$this->form_validation->set_rules('grp_size', 'grp_size', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('nb_place', 'nb_place', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('rating_scale', 'rating_scale', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nb_corrector', 'nb_corrector', 'trim|required|xss_clean');
		$this->form_validation->set_rules('types', 'types', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE
			&& $this->input->post("types") != "Types" && $this->input->post("module") != "Module parent")
		{
			$this->db->query("INSERT INTO `projects` (`name`, `desc`, `dt_start`, `dt_end`, `dt_end_insc`, `dt_end_corr`, `id_modules`, `pdf_url`, `rating_scale`, `grp_size`, `nb_place`, `nb_corrector`, `type`, `auto_insc`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
				array(
					$this->input->post("name"),
					$this->input->post("description"),
					$this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00",
					$this->input->post("dt_end") . " " . $this->input->post("dt_end_h") . ":00",
					$this->input->post("dt_end_insc") . " " . $this->input->post("dt_end_insc_h") . ":00",
					$this->input->post("dt_end_corr") . " " . $this->input->post("dt_end_corr_h") . ":00",
					$this->input->post("module"),
					$this->input->post("pdf_url"),
					$this->input->post("rating_scale"),
					$this->input->post("grp_size"),
					$this->input->post("nb_place"),
					$this->input->post("nb_corrector"),
					$this->input->post("types"),
					($this->input->post("auto_insc") ? 'TRUE' : 'FALSE')
					)
				);
			$bdd_users = $this->check_log->get_all_bdduser();
			$this->load->model('projects_m');
			foreach ($bdd_users as $user)
				$this->db->query('INSERT INTO `user_projects` (`user_id`, `project_id`, `id_master`) VALUES(?,?,?)',
					array(
						$user->id,
						$this->projects_m->get_project($this->input->post("name"))->id,
						$user->id
					));
			redirect(base_url());
		}
		$this->add_project();
	}


	/*
	**	MODULES
	*/
	public function		add_module()
	{
		if ($this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		loader($this, "admin/add_module");
	}

	public function validate_module()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean|alpha_dash|callback_check_name');
		$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nb_credit', 'nb_credit', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('nb_place', 'nb_place', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('dt_start', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start_h', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_h', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc_h', 'End inscription', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$this->db->query("INSERT INTO `modules` (`name`, `desc`, `credits`, `dt_start`, `dt_end`, `dt_end_insc`, `nb_place`) VALUES(?,?,?,?,?,?,?)",
				array(
					$this->input->post("name"),
					$this->input->post("description"),
					$this->input->post("nb_credit"),
					strtotime($this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00"),
					$this->input->post("dt_end") . " " . $this->input->post("dt_end_h") . ":00",
					$this->input->post("dt_end_insc") . " " . $this->input->post("dt_end_insc_h") . ":00",
					$this->input->post("nb_place")
					)
				);
			redirect(base_url());
		}
		$this->add_module();
	}

	function check_name()
	{
		if (empty($_POST['name']))
			return (false);
		if (preg_match('/^[a-zA-Z -_.]*$/', $_POST['name']))
			return (true);
		else
		{
			$this->form_validation->set_message('check_name', 'Bad title format.');
			return (false);
		}
	}
}