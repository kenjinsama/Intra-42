<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class install extends CI_Controller
{
	public function index()
	{
		if (file_exists(__DIR__ . "/../config/custom_config.php"))
		{
			header("Location:" . base_url());
			return ;
		}
		$this->load->view('install/install');
	}

	public function validate()
	{
		$this->form_validation->set_rules('hostname', 'Hostname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|matches[conf_pass]');
		$this->form_validation->set_rules('database', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pwd', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$content = $this::create_config();
			$fd = fopen( __DIR__ . "/../config/custom_config.php", "w+");
			fwrite($fd, $content);
			fclose($fd);
		}
		header("Location:" . base_url());
	}

	private function create_config()
	{
		$result =
				"<?php" . PHP_EOL .
				"$" . "_G_HOSTNAME = '" . $this->input->post('hostname') . "';" .PHP_EOL .
				"$" . "_G_USER = '" . $this->input->post('username') . "';" .PHP_EOL .
				"$" . "_G_PWD = '" . $this->input->post('password') . "';" .PHP_EOL .
				"$" . "_G_DB = '" . $this->input->post('database') . "';" .PHP_EOL .
				"$" . "_G_LOGIN = '" . $this->input->post('login') . "';" .PHP_EOL .
				"$" . "_G_MDP = '" . $this->input->post('pwd') . "';" .PHP_EOL .
				"?>";

		return ($result);
	}
}
