<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function		index()
	{
		$data["project"] = $this::get_projects();
		loader($this, array('home'), $data);
	}

	public function		get_projects()
	{
		$query = $this->db->query("SELECT `id`, `name`, `dt_end`, `dt_start`, `pdf_url`, `desc` FROM `projects` WHERE `dt_start` <= NOW() AND `dt_end` > NOW()");
		$query = $query->result_array();

		return ($query);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
