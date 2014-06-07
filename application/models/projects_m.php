<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Projects_m extends CI_Model
{
	public function		get_projects($id = NULL)
	{
		if ($id == NULL)
		{
			$query = $this->db->query("SELECT `id`, `name`, `dt_end`, `dt_start`, `pdf_url`, `desc`, `grp_size` FROM `projects` WHERE `dt_start` <= NOW() AND `dt_end` > NOW()");
			return ($query->result());
		}
		$query = $this->db->query('SELECT projects.id, projects.name, projects.desc, projects.dt_end, projects.dt_start FROM `projects` INNER JOIN `modules` ON projects.id_modules=modules.id WHERE modules.id="'.$id.'" AND projects.dt_start <= NOW() AND projects.dt_end > NOW()');
		return ($query->result());
	}

	public function 	get_all_projects()
	{
		$query = $this->db->query('SELECT * FROM `projects`');
		return $query->result();
	}

	public function		get_project($name = NULL)
	{
		if ($name)
			$this->db->where('name', $name);
		$query = $this->db->get('projects');
		if ($name == NULL)
			return ($query->result());
		else
		{
			$query = $query->result();
			return ($query[0]);
		}
	}

	public function		get_project_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('projects');
		$res = $query->result();
		return ($res[0]);
	}

	public function 	get_project_group($id, $project_id)
	{
		$query = $this->db->query('SELECT `id` FROM `user_projects` WHERE project_id = "'.$project_id.'" AND id_master = "'.$id.'"');
		return $query->result();
	}

	public function		get_project_stats($project_id, $user)
	{
		$query = $this->db->query('SELECT state FROM `user_projects` INNER JOIN `users` ON users.id = user_projects.user_id WHERE users.login = "'.$user.'" AND user_projects.project_id = "'.$project_id.'"');
		$res = $query->result();
		if (!$res)
			return (-1);
		return ($res[0]->state);
	}

	public function 	get_registered($project_id)
	{
		$query = $this->db->query('SELECT COUNT(*) AS nb FROM `user_projects` WHERE project_id = "'.$project_id.'" AND `state` = "REGISTERED"');
		$res = $query->result();
		return ($res[0]);
	}

	public function 	get_unregistered($project_id)
	{
		$query = $this->db->query('SELECT users.id, `login` FROM `users` INNER JOIN `user_projects` U ON users.id = U.user_id WHERE U.state = "UNREGISTERED" AND U.project_id = "'.$project_id.'"');
		$res = $query->result_array();
		return ($res);
	}

	public function 	get_totaltime($project_id)
	{
		$query = $this->db->query('SELECT dt_start, dt_end FROM `projects` WHERE id = "'.$project_id.'"');
		$res = $query->result();
		return (date_diff(date_create($res[0]->dt_start), date_create($res[0]->dt_end))->format('%d jours et %h heures'));
	}

	public function		get_projects_correction()
	{
		$query = $this->db->query("SELECT projects.id, name FROM `projects` INNER JOIN `user_projects` U ON U.project_id = projects.id
			WHERE U.user_id = ? AND projects.dt_end < NOW() AND projects.dt_end_corr > NOW()", array($this->session->userdata('user_id')));

		return ($query->result_array());
	}

	/*
	**	Retourne les infos sur les correcteurs de l'utilisateur connecté et génere les correcteurs si ce n'est pas fait
	*/
	public function		get_corrector($id)
	{
		$query = $this->db->query("SELECT `corrector_id`, `rate`, `nb_stars`, `done` FROM `ratings`
			WHERE `id_project` = ? AND `id_user` = ?", array($id, $this->session->userdata('user_id')));

		$query = $query->result_array();

		/*
		**	Si aucun resultat alors on genere les correcteurs
		*/
		if (count($query) == 0)
		{
			/*
			**	On verifie qu'il y a plusieurs inscrits sinon on return(NULL)
			*/
			$query = $this->db->query("SELECT COUNT('id') AS nb FROM `user_projects` WHERE `project_id` = '".$id."'");
			$query = $query->result_array();
			if ($query[0]["nb"] < 1)
				return (NULL);


			$query = $this->db->query("SELECT `user_id` FROM `user_projects` WHERE `project_id` = ?", array($id));
			$users = $query->result_array();
			$nb_corrector = $this->db->query("SELECT `nb_corrector` FROM `projects` WHERE `id` = ?", array($id));
			$nb_corrector = $nb_corrector->result_array();
			$nb_corrector = $nb_corrector[0]["nb_corrector"];

			// On genere autant de correcteur que demandé dans la limite du possible
			$i = 0;
			$tbl = array();
			foreach ($users as $data)
			{
				for ($j = 0; $j < $nb_corrector; $j++)
					$tbl[] = $i;
				$i++;
			}

			// On enregistre les correcteurs
			foreach ($users as $data)
			{
				if (count($tbl) < 2)
				{
					$query = $this->db->query("SELECT `corrector_id`, `rate`, `nb_stars`, `done` FROM `ratings`
					WHERE `id_project` = ? AND `id_user` = ?", array($id, $this->session->userdata('user_id')));
					return($query->result_array());
				}
				$i = 0;
				while ($i < $nb_corrector)
				{
					$rand = rand(0, count($tbl) - 1);
					if(isset($tbl[$rand]))
					{
						$this->db->query("INSERT INTO `ratings` (id_user, id_project, corrector_id, done) VALUES(?,?,?,?)",
							array(
								$data["user_id"],
								$id,
								$users[$tbl[$rand]]['user_id'],
								0
							)
						);
						unset($tbl[$rand]);
						$tbl = array_values($tbl);
					}
					$i++;
				}
			}

			// On retourne chercher les infos des correcteurs
			$query = $this->db->query("SELECT `corrector_id`, `rate`, `nb_stars`, `done` FROM `ratings`
			WHERE `id_project` = ? AND `id_user` = ?", array($id, $this->session->userdata('user_id')));
			$query = $query->result_array();
		}
		return ($query);
	}

	public function		get_corrected($id)
	{
		$query = $this->db->query("SELECT `id_user`, `rate`, `nb_stars`, `done` FROM `ratings`
			WHERE `id_project` = ? AND `corrector_id` = ?", array($id, $this->session->userdata('user_id')));

		return ($query->result_array());
	}

	public function 	register_user($user_id, $project_id)
	{
		$this->db->query("INSERT INTO `user_projects` (`user_id`, `project_id`, `state`) VALUES(?,?,?)",
			array(
				'user_id' => $user_id,
				'project_id' => $project_id,
				'state' => 'REGISTERED'
			));
	}
}