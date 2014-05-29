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

	public function		get_projects($name)
	{
		$query = $this->db->query('SELECT projects.name FROM `projects` INNER JOIN `modules` ON projects.id_modules=modules.id WHERE modules.name="' . $name . '"');
		return ($query->result());
	}

	public function		get_project($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('projects');
		$res = $query->result();
		return ($res[0]);
	}
}

?>