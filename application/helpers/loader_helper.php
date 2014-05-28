<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loader'))
{
	function loader($controller, $view)
	{
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			header("Location: " . base_url() . "install/");
		if ($controller->check_log->check_login() == FALSE)
			header("Location: " . base_url() . "connexion/");
		$controller->load->view('main/header');

		if (is_array($view))
		{
			foreach ($view as $data)
				$controller->load->view($data);
		}
		else if (is_string($view))
			$controller->load->view($view);
		$controller->load->view('main/footer');
	}
}
