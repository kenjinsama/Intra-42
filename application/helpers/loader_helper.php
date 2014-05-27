<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loader'))
{
	function loader($controller, $view)
	{
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			header("Location: " . base_url() . "install/");
		$controller->load->view('main/header');

		$controller->load->view($view);

		$controller->load->view('main/footer');
	}
}
