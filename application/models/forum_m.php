<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forum_m extends CI_Model {

	function get_index()
	{
		$this->db->where('id_parent IS NULL');
		$query = $this->db->get('categories');
		return ($query->result());
	}

	function get_categories_for($name)
	{
		$this->db->select('id');
		$this->db->where('name', $name);
		$query = $this->db->get('categories');
		$results = $query->result();
		$id = -1;
		foreach ($results as $result)
		{
			$id = $result->id;
		}
		$this->db->where('id_parent', $id);
		$query = $this->db->get('categories');
		return ($query->result()); 
	}
}

?>