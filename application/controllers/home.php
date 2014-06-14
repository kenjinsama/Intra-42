<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Home extends CI_Controller
{
	public function		index()
	{
		$this->load->model('projects_m');
		$data["projects"] = $this->projects_m->get_projects();
		$query = $this->db->query("SELECT `name`, `dt_end`, `dt_start`, `id` FROM `projects` WHERE `dt_end` > NOW() ORDER BY `dt_start`");
		$data["planning"] = $query->result_array();
		loader($this, array('home', 'planning'), $data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
