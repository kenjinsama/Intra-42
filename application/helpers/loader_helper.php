<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loader'))
{
	function loader($controller, array $view)
	{
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			header("Location: " . base_url() . "install/");
		if ($controller->check_log->check_login() == FALSE)
			header("Location: " . base_url() . "connexion/");
		$controller->load->view('main/header');

		foreach ($view as $data)
			$controller->load->view($data);

		$controller->load->view('main/footer');
	}
}
