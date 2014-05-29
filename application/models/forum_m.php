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

	function format_urls($curr_url)
	{
		$exploded = explode('/', $curr_url);
		$exploded = array_splice($exploded, 3);
		$url = base_url();

		$urls = array('home' => base_url());
		foreach ($exploded as $category)
		{
			$url .= $category . '/';
			$category = preg_replace('/%20/', ' ', $category);
			$urls[$category] = $url;
		}
		return ($urls);
	}
}

?>