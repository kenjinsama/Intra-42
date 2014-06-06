<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$this->load->view('home');
=======
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
		loader($this, 'home', $data);
>>>>>>> 1220e2045ab20ab60daba75584e5b79f955691f2
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
