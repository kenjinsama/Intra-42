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
		$this->load->model("modules_m");
		$this->load->model("projects_m");
		$this->load->library('table');
		$data["modules"] = $this->convert_mod_tbl($this->modules_m->get_modules());
		$data["projects"] = $this->convert_proj_tbl($this->projects_m->get_project());
		loader($this, "admin/index", $data);
	}

	/*
	**	CONVERTION : convertie le resultats des requetes pour generer tableau html
	*/
	private function	convert_proj_tbl($proj)
	{
		$result = array(array("Nom", "start", "end", "nb_place", "Editer", "Supprimer"));
		$i = 1;
		foreach ($proj as $data)
		{
			$result[$i] = array(
						$data->name,
						$data->dt_start,
						$data->dt_end,
						$data->nb_place,
						anchor(base_url() . "admin/edit_p/" . $data->id, "Editer"),
						anchor(base_url() . "admin/del_p/" . $data->id, "Supprimer")
						);
			$i++;
		}
		return ($result);
	}

	private function	convert_mod_tbl($proj)
	{
		$result = array(array("Nom", "start", "end", "nb_place", "Editer", "Supprimer"));
		$i = 1;
		foreach ($proj as $data)
		{
			$result[$i] = array(
						$data->name,
						$data->dt_start,
						$data->dt_end,
						$data->nb_place,
						anchor(base_url() . "admin/edit_m/" . $data->id, "Editer"),
						anchor(base_url() . "admin/del_m/" . $data->id, "Supprimer")
						);
			$i++;
		}
		return ($result);
	}

	/*
	**	SUPPRESSION : supprime les modules et projets avec l'id rentré en parametre
	*/
	public function		del_p($id = NULL)
	{
		if ($id == NULL || $this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->db->query("DELETE FROM `projects` WHERE `id` LIKE ?", array($id));
		redirect(base_url() . "admin");
	}

	public function		del_m($id = NULL)
	{
		if ($id == NULL || $this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->db->query("DELETE FROM `modules` WHERE `id` LIKE ?", array($id));
		redirect(base_url() . "admin");
	}


	/*
	**	EDITION : edit les modules et projets
	*/
	public function		edit_m($id = NULL)
	{
		if ($id == NULL || $this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->load->model("modules_m");
		$data["modules"] = $this->modules_m->get_module($id);
		loader($this, "admin/edit_module", $data);
	}

	public function		edit_p($id = NULL)
	{
		if ($id == NULL || $this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->load->model("projects_m");
		$this->load->model('modules_m');
		$data['modules'] = $this->modules_m->get_modules();
		$data["projects"] = $this->projects_m->get_project_by_id($id);
		loader($this, "admin/edit_project", $data);
	}

	/*
	** VALIDATION FORMULAIRE EDITION
	*/
	public function validate_edit_m($id)
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean|alpha_dash|callback_check_name');
		$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nb_credit', 'nb_credit', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('nb_place', 'nb_place', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('dt_start', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start_h', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_h', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc_h', 'End inscription', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$this->db->query("UPDATE `modules` SET `name` = ?, `desc` = ?, `credits` = ?, `dt_start` = ?, `dt_end` = ?, `dt_end_insc` = ?, `nb_place` = ? WHERE `id` LIKE ?",
				array(
					$this->input->post("name"),
					$this->input->post("description"),
					$this->input->post("nb_credit"),
					$this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00",
					$this->input->post("dt_end") . " " . $this->input->post("dt_end_h") . ":00",
					$this->input->post("dt_end_insc") . " " . $this->input->post("dt_end_insc_h") . ":00",
					$this->input->post("nb_place"),
					$id
					)
				);
			redirect(base_url() . "admin");
		}
		$this->edit_m($id);
	}

	public function validate_edit_p($id)
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
			$this->db->query("UPDATE `projects` SET `name` = ?, `desc` = ?, `dt_start` = ?, `dt_end` = ?, `dt_end_insc` = ?, `dt_end_corr` = ?, `id_modules` = ?, `pdf_url` = ?, `rating_scale` = ?, `grp_size` = ?, `nb_place` = ?, `nb_corrector` = ?, `type` = ?, `auto_insc` = ? WHERE `id` = ?",
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
					($this->input->post("auto_insc") ? 'TRUE' : 'FALSE'),
					$id
					)
				);
			redirect(base_url() . "admin");
		}
		$this->edit_p($id);
	}

	/*
	**	AJOUT PROJETS
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
			redirect(base_url());
		}
		$this->add_project();
	}


	/*
	**	AJOUT MODULES
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
					$this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00",
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