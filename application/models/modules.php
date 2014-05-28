<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Modules extends CI_Model
{
	public function		get_modules()
	{
		$query = $this->db->get('modules');
		return ($query->result());
	}
}

?>