<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Update_bdd extends CI_Model
{

	/*
	**	UPDATE LA TABLE USERS TOUTE LES 24H
	*/
	public function		load_user()
	{
		$query = $this->db->query("SELECT `date` FROM `update` ORDER BY `id` DESC LIMIT 1");
		$res = $query->result_array();

		if (count($res) == 0 || (isset($res["date"]) && strtotime($res["date"]) < time() - (24 * 3600)))
		{
			if ($this->check_log->check_login())
			{
				/*
				**	On créé une trace de l'update dans la bdd pour eviter les synchro automatique
				*/
				$this->db->query("INSERT INTO `update` (`date`) VALUES(NOW())");
				// on charge tout les users
				$ldap = $this->ldap->get_all();
				foreach ($ldap as $data)
				{
					if (isset($data["cn"][0]))
					{
						// on verifie qu'il n'est pas deja present dans la bdd
						$query = $this->db->query("SELECT COUNT(`id`) FROM `users` WHERE `login` = ?", array($data["uid"][0]));
						$query = $query->result_array();
						if (!isset($query[0]["COUNT(`id`)"]))
							return;

						// si c'est un nouveau user on l'enregistre en bdd
						if ($query[0]["COUNT(`id`)"] == 0)
						{
							$this->db->query("INSERT INTO `users` (`login`, `cn`, `picture`, `status`) VALUES (?, ?, ?, ?)",
								array(
									$data["uid"][0],
									$data["cn"][0],
									(isset($data["picture"][0]) ? base64_encode($data["picture"][0]) : DEFAULT_IMG),
									"STUDENT"
								)
							);
						}
					}
				}
			}
		}
	}

	/*
	**	Inscrire tout le monde à un module sans doublon
	**	insc_all_m($id = id du module, $status = statut de l'inscription)
	*/
	public function		insc_all_m($id, $status)
	{
		// On selectionne les utilisateurs non inscrit
		$query = $this->db->query("SELECT `id` FROM `users` WHERE NOT EXISTS (
			SELECT * FROM `user_modules` WHERE `user_id` = users.id AND module_id = ?)", array($id));
		$users = $query->result_array();

		foreach ($users as $data)
		{
			$this->db->query("INSERT INTO `user_modules` (`user_id`, `module_id`, `state`) VALUES(?, ?, ?)",
				array(
					$data["id"],
					$id,
					$status
				)
			);
		}
	}

	/*
	**	Inscrire tout le monde à un projet sans doublon en mode projet solo
	**	insc_all_p($id = id du projet, $status = statut de l'inscription)
	*/
	public function		insc_all_p($id, $status)
	{
		// On selectionne les utilisateurs non inscrit
		$query = $this->db->query("SELECT `id` FROM `users` WHERE NOT EXISTS (
			SELECT * FROM `user_projects` WHERE `user_id` = users.id AND project_id = ?)", array($id));
		$users = $query->result_array();

		foreach ($users as $data)
		{
			$this->db->query("INSERT INTO `user_projects` (`user_id`, `project_id`, `state`, `id_master`) VALUES(?, ?, ?, ?)",
				array(
					$data["id"],
					$id,
					$status,
					$data["id"],
				)
			);
		}
	}

	/*
	**	Inscrire tout les utilisateurs rentré en parametre à un module
	**	insc_users_m(Array $users, $id, $status)
	**
	**	users est un tableau de users sous la forme array([0]=> X, ...))
	**	id est l'id du projet et status le status de l'inscription
	*/
	public function		insc_users_m($users, $id, $status)
	{
		foreach ($users as $data)
		{
			// On verifie qu'un cas semblable n'est pas déjà enregistré
			$query = $this->db->query("SELECT COUNT(`id`), `state` FROM `user_modules` WHERE `user_id` = ? AND `module_id` = ?",
				array(
					$data,
					$id
				)
			);
			$query = $query->result_array();

			// Si non on insert
			if ($query[0]["COUNT(`id`)"] == 0)
			{
				$this->db->query("INSERT INTO `user_modules` (`user_id`, `module_id`, `state`) VALUES(?, ?, ?)",
					array(
						$data,
						$id,
						$status
					)
				);
			} // Mais si il existe un cas semblable avec un autre etat on update
			else if ($query[0]["state"] != $status)
			{
				$this->db->query("UPDATE `user_modules` SET `state`=? WHERE `user_id` = ? AND `module_id` = ?",
					array(
						$status,
						$data,
						$id
					)
				);
			}
		}
	}

	/*
	**	Inscrire tout les utilisateurs rentré en parametre à un projet en mode projet solo
	**	insc_users_p(Array $users, $id, $status)
	**
	**	$users est un tableau de users sous la forme array([0]=> X, ...))
	**	id est l'id du projet et status le status de l'inscription
	*/
	public function		insc_users_p($users, $id, $status)
	{
		foreach ($users as $data)
		{
			// On verifie qu'un cas semblable n'est pas déjà enregistré
			$query = $this->db->query("SELECT COUNT(`id`), `state`, `id_master` FROM `user_projects` WHERE `user_id` = ? AND `project_id` = ?",
				array(
					$data,
					$id
				)
			);
			$query = $query->result_array();

			// Si non on insert
			if ($query[0]["COUNT(`id`)"] == 0)
			{
				$this->db->query("INSERT INTO `user_projects` (`user_id`, `project_id`, `state`, `id_master`) VALUES(?, ?, ?, ?)",
					array(
						$data,
						$id,
						$status,
						$data,
					)
				);
			} // Mais si il existe un cas semblable avec un autre etat ou autre chef de grp on update
			else if ($query[0]["state"] != $status || $query[0]["id_master"] != $data)
			{
				$this->db->query("UPDATE `user_projects` SET `state` = ?, `id_master` = ? WHERE `user_id` = ? AND `project_id` = ?",
					array(
						$status,
						$data,
						$data,
						$id,
					)
				);
			}
		}
	}

	/*
	**	Inscrire tout les utilisateurs rentré en parametre à un projet en mode projet par groupe
	**	insc_grp_p(Array $users, $id, $status)
	**
	**	users est un tableau de users sous la forme array([0]=>array([0] => X, [1] => X ...), [1] => array(...))
	**	tel que X est les id_users et l'index 0 du tableau d'id represente le chef de groupe
	**	id est l'id du projet et status le status de l'inscription
	*/
	public function		insc_grp_p($users, $id, $status)
	{
		foreach ($users as $grp)
		{
			foreach ($grp as $data)
			{
				// On verifie qu'un cas semblable n'est pas déjà enregistré
				$query = $this->db->query("SELECT COUNT(`id`), `state`, `id_master` FROM `user_projects` WHERE `user_id` = ? AND
					`project_id` = ?",
					array(
						$data,
						$id
					)
				);
				$query = $query->result_array();

				// Si non on insert
				if ($query[0]["COUNT(`id`)"] == 0)
				{
					$this->db->query("INSERT INTO `user_projects` (`user_id`, `project_id`, `state`, `id_master`) VALUES(?, ?, ?, ?)",
						array(
							$data,
							$id,
							$status,
							$grp[0],
						)
					);
				} // Mais si il existe un cas semblable avec un autre etat ou autre chef de grp on update
				else if ($query[0]["state"] != $status || $query[0]["id_master"] != $data["id"])
				{
					$this->db->query("UPDATE `user_projects` SET `state`=?, `id_master`=? WHERE `user_id` = ? AND `project_id` = ?",
						array(
							$status,
							$data,
							$data,
							$id,
						)
					);
				}
			}
		}
	}
}