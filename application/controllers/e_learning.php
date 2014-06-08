<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class E_learning extends CI_Controller
{
	public function		index()
	{
		$this->project();
	}

	public function 	project($id = NULL)
	{

		$query = $this->db->query('SELECT * FROM `uploads` WHERE id_project = "'.$id.'"');

		$data['project'] = $query->result();
		loader($this, 'user/e_learning_project', $data);
	}

	public function 	add_video($data = NULL)
	{
		if ($this->check_log->check_log_admin() == FALSE)
			redirect(base_url());
		$this->load->model('projects_m');
		$data['projects'] = $this->projects_m->get_all_projects();
		loader($this, 'admin/add_video', $data);
	}

	public function 	upload_video()
	{
		if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '')
		{
			unset($config);
			$date = date("ymd");
			$configVideo['upload_path'] = 'uploads/video';
			$configVideo['max_size'] = '10240';
			$configVideo['allowed_types'] = 'avi|flv|wmv|mp3|mp4';
			$configVideo['overwrite'] = FALSE;
			$configVideo['remove_spaces'] = TRUE;
			$configVideo['file_name'] = $this->input->post('name').substr(strrchr($date.$_FILES['video']['name'], '.'), 0);
			if ($configVideo['file_name'] == null)
				$configVideo['file_name'] = $date.$_FILES['video']['name'];

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('video'))
				$data['error'] = $this->upload->display_errors();
			else
			{
				$this->db->query('INSERT INTO `uploads` (`path`, `type`, `id_project`) VALUE(?,?,?)', array(
						$configVideo['upload_path']."/".$configVideo['file_name'],
						'VIDEO',
						$this->input->post('project')
					));
				$videoDetails = $this->upload->data();
				$data['ok'] = "Successfully Uploaded";
			}
		}
		else
			$data['error'] =  'Wrong files';
		$this->add_video($data);
	}
}