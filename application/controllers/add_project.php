<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Add_project extends CI_Controller
{
	public function index()
	{
		$this->load->model('modules');
		$data['modules'] = $this->modules->get_modules();
		loader($this, 'admin/add_project', $data);
	}

	public function validate()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_corr', 'End correction', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_start_h', 'Start date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_h', 'deadline', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_insc_h', 'End inscription', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dt_end_corr_h', 'End correction', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module', 'module', 'trim|required|xss_clean|is_natural|numeric');
		$this->form_validation->set_rules('pdf_url', 'pdf_url', 'trim|required|xss_clean');
		$this->form_validation->set_rules('rating_scale', 'rating_scale', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$this->db->query("INSERT INTO `projects` (`name`, `desc`, `dt_start`, `dt_end`, `dt_end_insc`, `dt_end_corr`, `id_modules`, `pdf_url`, `rating_scale`) VALUES(?,?,?,?,?,?,?,?,?)",
				array(
					$this->input->post("name"),
					$this->input->post("description"),
					$this->input->post("dt_start") . " " . $this->input->post("dt_start_h") . ":00",
					$this->input->post("dt_end") . " " . $this->input->post("dt_end_h") . ":00",
					$this->input->post("dt_end_insc") . " " . $this->input->post("dt_end_insc_h") . ":00",
					$this->input->post("dt_end_corr") . " " . $this->input->post("dt_end_corr_h") . ":00",
					$this->input->post("module"),
					$this->input->post("pdf_url"),
					$this->input->post("rating_scale")
				)
			);
			header("Location:" . base_url());
			return ;
		}
		$this->index();
	}
}
