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

	public function projects($id)
	{
		$this->load->model('projects_m');
		$this->load->model('modules_m');
		$module = $this->modules_m->get_module($id);
		$data['id'] = $id;
		$query = $this->db->query("SELECT COUNT(`id`) FROM `user_modules` WHERE `user_id` = ? AND `module_id` = ?",
			array(
				$this->session->userdata("user_id"),
				$id
			)
		);
		$query = $query->result_array();
		$nb_insc = $this->db->query("SELECT COUNT(`id`) FROM `user_modules` WHERE `state` = 'REGISTERED' AND `module_id` = ?",
			array(
				$id
			)
		);
		$nb_insc = $nb_insc->result_array();
		if ($query[0]["COUNT(`id`)"] == 0)
		{
			$data["button"] = array(
						"name" => "Inscription",
						"url" => strtotime($module->dt_end_insc) > time() || $nb_insc[0]["COUNT(`id`)"] >= $module->nb_place ? base_url() . "module/module_register/" . $id : NULL,
						"class" => array("class" => "btn btn-lg btn-success")
					);
		}
		else
		{
			$data["button"] = array(
						"name" => "Desinscription",
						"url" => strtotime($module->dt_end_insc) > time() ? base_url() . "module/module_unregister/" . $id : NULL,
						"class" => array("class" => "btn btn-lg btn-danger")
					);
		}
		$data['projects'] = $this->projects_m->get_projects($id);
		loader($this, 'user/projects_list', $data);
	}

	public function project($id)
	{
		$this->load->model('projects_m');
		$data['project'] = $this->projects_m->get_project_by_id($id);
		$query = $this->db->query("SELECT COUNT(`id`) FROM `user_modules` WHERE `user_id` = ? AND `module_id` = ?", array($this->session->userdata("user_id"), $data["project"]->id_modules));
		$query = $query->result_array();
		$nb_insc = $this->db->query("SELECT COUNT(`id`) FROM `user_projects` WHERE `state` = 'REGISTERED' AND `project_id` = ?", array($id));
		$nb_insc = $nb_insc->result_array();
		$data["nb_insc"] = $nb_insc[0]["COUNT(`id`)"];
		if ($query[0]["COUNT(`id`)"] == 0 || strtotime($data['project']->dt_end_insc) < time() || $nb_insc[0]["COUNT(`id`)"] >= $data['project']->nb_place)
			$data["available"] = FALSE;
		else
			$data["available"] = TRUE;

		$query = $this->db->query("SELECT `user_id`, `id_master`, `state` FROM `user_projects` WHERE `user_id` = ? AND `project_id` = ?",
			array(
				$this->session->userdata("user_id"),
				$id
			)
		);
		$query = $query->result_array();
		if (isset($query[0]) && $query[0]["id_master"] != $query[0]["user_id"])
		{
			$grp = $this->db->query("SELECT `user_id`, `id_master`, `state` FROM `user_projects` WHERE `id_master` = ? AND `project_id` = ?",
				array(
					$query[0]["id_master"],
					$id
				)
			);
			$grp = $grp->result_array();
			$data["grp"] = $grp;
		}
		if (isset($query[0]))
			$data["inscription"] = $query[0];
		loader($this, 'user/project', $data);
	}

	public function group_register()
	{
		$this->load->model('projects_m');
		$data['project_id'] = $this->input->get('project_id');
		loader($this, 'user/group_register', $data);
	}

	public function module_register($id)
	{
		$this->db->query("INSERT INTO `user_modules` (`user_id`, `module_id`, `state`) VALUES(?,?,?)",
			array(
				$this->session->userdata("user_id"),
				$id,
				"REGISTERED"
			)
		);

		$query = $this->db->query("SELECT P.id FROM `projects` AS P INNER JOIN `modules` M ON P.id_modules = M.id");
		$query = $query->result_array();
		$this->load->model("update_bdd");
		foreach ($query as $data)
			$this->update_bdd->insc_all_p($data['id'], "UNREGISTERED");
		redirect(base_url() . "module/projects/" . $id);
	}

	public function module_unregister($id)
	{
		$this->db->query("DELETE FROM `user_modules` WHERE `user_id` = ? AND `module_id` = ?",
			array(
				$this->session->userdata("user_id"),
				$id
			)
		);
		redirect(base_url() . "module/projects/" . $id);
	}

	public function project_register()
	{
		$this->load->model('projects_m');
		$query = $this->db->query('SELECT `grp_size` FROM `projects` WHERE id="'.$this->input->get('id').'"');
		$res = $query->result();
		if ($res[0]->grp_size > 1)
		{
			redirect(base_url().'module/group_register?project_id='.$this->input->get('id'));
			return ;
		}
		$this->load->model("update_bdd");
		$this->update_bdd->insc_users_p(array($this->session->userdata("user_id")), $this->input->get('id'), "REGISTERED");
		redirect(base_url().'module/project/'.$this->input->get('id'));
	}

	public function project_unregister($id)
	{
		$this->load->model('projects_m');
		$this->db->query("UPDATE `user_projects` SET `state` = 'UNREGISTERED' WHERE `project_id` = ? AND `user_id` = ? OR `id_master` = ?",
			array(
				$id,
				$this->session->userdata("user_id"),
				$this->session->userdata("user_id")
			)
		);
		redirect(base_url() . 'module/project/' . $id);
	}

	public function validate($id_project, $users)
	{
		$users = explode("#->", $users);

		foreach ($users as $user)
			$this->db->query('UPDATE `user_projects` SET state = "REGISTERED" , id_master = "'.$this->session->userdata('user_id').'" WHERE user_id = "'.$this->check_log->obtain_id($user).'"');
		$this->db->query('UPDATE `user_projects` SET state = "REGISTERED" WHERE user_id = "'.$this->session->userdata('user_id').'"');
		redirect("/");
	}

	public function project_correction($project_id, $corrected_user)
	{
		if (!isset($project_id) || !isset($corrected_user))
			redirect("/");
		$query = $this->db->query('SELECT `rating_scale` FROM `projects` WHERE id="'.$project_id.'"');
		$data = array();
		if (isset($query->result()[0]->rating_scale))
			$data['rating_scale'] = $query->result()[0]->rating_scale;
		$data['project_id'] = $project_id;
		$data['corrected_user'] = $corrected_user;
		loader($this, 'user/project_correction', $data);
	}

	public function validate_corr($project_id, $id_user)
	{
		$nbmod = $this->input->post('nb-mod');
		$i = 0;
		$note = 0;
		$coms = '';
		while ($i < $nbmod)
		{
			$note += $this->input->post('note-'.$i);
			$coms .= $this->input->post('com-name-'.$i)."<BR />";
			$coms .= strtr($this->input->post('com-'.$i), array('\n' => '<BR />') )."<BR />";
			$i++;
		}
		echo $note;
		echo $coms;
		$this->db->query('UPDATE `ratings` SET `rate` = "'.$note.'", coms = "'.$coms.'" WHERE `id_project` = "'.$project_id.'" AND `corrector_id` = "'.$this->session->userdata('user_id').'" AND `id_user` = "'.$id_user.'"');
		redirect(base_url());
	}
}