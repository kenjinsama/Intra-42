<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Modules_m extends CI_Model
{
	public function		get_modules()
	{
		$query = $this->db->get('modules');
		return ($query->result());
	}

	public function		get_module($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('modules');
		$res = $query->result();
		return ($res[0]);
	}

	/*
	**	Retourne un tableau contenant tous les id des users inscrit au module tel que module_id = $id
	*/
	public function		get_users_register($id)
	{
		$query = $this->db->query("SELECT `user_id` FROM `user_modules` WHERE `module_id` = ?", array($id));
		return ($query->result_array());
	}

	/*
	**	Retourne un tableau contenant tous les id des modules auquel un user est inscrit
	*/

	public function	 get_modules_from_user($user_id)
	{
		$query = $this->db->query("SELECT `module_id` FROM `user_modules` WHERE `user_id` = ?", $user_id);
		return ($query->result_array());
	}

	/*
	**	Retourne un tableau contenant tous les id des modules finis auquel un user s'était inscrit
	*/

	public function	 get_finished_modules_from_user($user_id)
	{
		$tab_res = NULL;
		$query = $this->db->query("SELECT `module_id` FROM `user_modules` INNER JOIN `modules` U ON `module_id` = U.id WHERE `user_id` = '$user_id' AND U.dt_end < NOW()");
		$res = $query->result();
		foreach ($res as $mod_id) {
			$tab_res[] = $this->get_module($mod_id->module_id)->name;
		}
		return ($tab_res);
	}

	/*
	**	Retourne un tableau contenant tous les id des modules en cours auquel un user est inscrit
	*/

	public function	 get_current_modules_from_user($user_id)
	{
		$tab_res = NULL;
		$query = $this->db->query("SELECT `module_id` FROM `user_modules` INNER JOIN `modules` U ON `module_id` = U.id WHERE `user_id` = '$user_id' AND U.dt_end > NOW()");
		$res = $query->result();
		foreach ($res as $mod_id) {
			$tab_res[] = $this->get_module($mod_id->module_id)->name;
		}
		return ($tab_res);
	}


	/*
	**	Retourne un tableau contenant tous les id des prochains modules
	*/

	public function	 get_futures_modules()
	{
		$tab_res = NULL;
		$query = $this->db->query("SELECT `id` FROM `modules` WHERE `dt_start` > NOW()");
		$res = $query->result();
		foreach ($res as $mod_id) {
			$tab_res[] = $this->get_module($mod_id->id)->name;
		}
		return ($tab_res);
	}


	/*
	**	Retourne un tableau contenant tous les id des modules auquel qu'un user a validé
	*/

	public function get_validated_modules_from_user($user_id)
	{
		$query = $this->db->query("SELECT `module_id` FROM `user_modules` WHERE `user_id` = '$user_id' AND `state` = 'VALIDATED'");
		return ($query->result_array());
	}

	/*
	**	Retourne un nombre de credits totaux correspondant a l'integralité des modules auquel un user est inscrit
	*/

	private function get_credits_from_module($module_id)
	{
		$this->db->where('id', $module_id);
		$query = $this->db->get('modules');
		$res = $query->result();
		return ($res[0]->credits);
	}

	public function get_total_credits_from_module($array)
	{
		$total_cred = 0;
		foreach ($array as $data)
		{
			$credits = $this->get_credits_from_module($data['module_id']);
			$total_cred += $credits;
		}
		return ($total_cred);
	}

}

?>
