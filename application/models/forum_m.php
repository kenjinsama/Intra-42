<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forum_m extends CI_Model {

	function Forum_m()
	{
		parent::Model();
	}

	function get_index() {
		$this->db->where('id_parent', 'NULL');
		$query = $this->db->get('name');
		return ($query->result());
	}
}

?>