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

}

?>
