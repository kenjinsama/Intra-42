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
}

?>