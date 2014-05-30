<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class add_module extends CI_Controller
{
	public function index()
	{
		loader($this, 'admin/add_module');
	}

	public function validate()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean|alpha_dash');
		$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('nb_credit', 'nb_credit', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('dt_start', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start_h', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_h', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc_h', 'End inscription', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$this->db->query("INSERT INTO `modules` (`name`, `desc`, `credits`, `dt_start`, `dt_end`, `dt_end_insc`) VALUES(?,?,?,?,?,?)",
				array(
					$this->input->post("name"),
					$this->input->post("description"),
					$this->input->post("nb_credit"),
					strtotime($this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00",
					$this->input->post("dt_end") . " " . $this->input->post("dt_end_h") . ":00",
					$this->input->post("dt_end_insc") . " " . $this->input->post("dt_end_insc_h") . ":00"
					)
				));
			header("Location:" . base_url());
			return ;
		}
		$this->index();
	}
}
