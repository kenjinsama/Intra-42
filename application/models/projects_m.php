<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Projects_m extends CI_Model
{
	public function		get_projects($name = NULL)
	{
		if ($name == NULL)
		{
			$query = $this->db->query("SELECT `id`, `name`, `dt_end`, `dt_start`, `pdf_url`, `desc` FROM `projects` WHERE `dt_start` <= NOW() AND `dt_end` > NOW()");
			return ($query->result());
		}
		$query = $this->db->query('SELECT projects.id, projects.name, projects.desc, projects.dt_end, projects.dt_start FROM `projects` INNER JOIN `modules` ON projects.id_modules=modules.id WHERE modules.name="'.$name.'" AND projects.dt_start <= NOW() AND projects.dt_end > NOW()');
		return ($query->result());
	}

	public function		get_project($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('projects');
		$res = $query->result();
		return ($res[0]);
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
		$query = $this->db->query('SELECT COUNT(*) AS nb FROM `user_projects` WHERE project_id = "'.$project_id.'"');
		$res = $query->result();
		return ($res[0]);
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

	public function		get_correction($id)
	{
		$query = $this->db->query("SELECT `corrector_id`, `rate`, `nb_stars`, `done` FROM `ratings`
			WHERE `id_project` = ? AND `id_user` = ?", array($id, $this->session->userdata('user_id')));

		$query = $query->result_array();
		if (!$query)
		{
			$query = $this->db->query("SELECT `user_id` FROM `user_projects` WHERE `project_id` = ?", array($id));
			$query = $query->result_array();
			$i = 0;
			$tbl = array();
			foreach ($query as $data)
			{
				for ($j = 0; $j < 1; $j++)
					$tbl[$i * 1 + $j] = $i;
				$i++;
			}
			foreach ($query as $data)
			{
				$rand = rand(0, count($tbl) - 1);
				var_dump($tbl);
				var_dump($tbl[$rand]);
				$this->db->query("INSERT INTO `ratings` (id_user, id_project, rate, nb_stars, corrector_id, done) VALUES(?,?,?,?,?,?)",
					array(
						$data["user_id"],
						$id,
						0,
						0,
						$tbl[$rand],
						0
					)
				);
				unset($tbl[$rand]);
				$tbl = array_values($tbl);
			}
			$query = $this->db->query("SELECT `corrector_id`, `rate`, `nb_stars`, `done` FROM `ratings`
			WHERE `id_project` = ? AND `id_user` = ?", array($id, $this->session->userdata('user_id')));
			$query = $query->result_array();
		}
		return ($query);
	}
}