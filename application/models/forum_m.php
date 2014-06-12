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

	function get_posts_for($name)
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
		$this->db->where('id_category', $id);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('posts');
		return ($query->result());
	}

	function get_categorie_id($name)
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
		return ($id);
	}

	function get_thread($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('posts');
		$results = $query->result();
		$thread = 0;
		foreach ($results as $result)
		{
			$thread = $result;
		}
		return ($thread);
	}

	function get_answers($id)
	{
		$this->db->where('id_post', $id);
		$query = $this->db->get('answer');
		$results = $query->result();
		$answers = array();
		foreach ($results as $result)
		{
			echo $this->get_user($this->session->userdata('user_id'))->status . ' ' . $this->forum_l->check_visibility($result->visibility, $this->get_user($this->session->userdata('user_id'))->status);
			if ($this->forum_l->check_visibility($result->visibility, $this->get_user($this->session->userdata('user_id'))->status))
			{
				$answers[] = $result;
			}
		}
		return ($answers);
	}

	function get_user($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('users');
		$results = $query->result();
		$user = 0;
		foreach ($results as $result)
		{
			$user = $result;
		}
		return ($user);
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