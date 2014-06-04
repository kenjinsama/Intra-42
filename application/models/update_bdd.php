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
}