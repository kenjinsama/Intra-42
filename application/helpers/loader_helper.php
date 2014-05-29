<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loader'))
{
	function loader($controller, $view, $data = NULL)
	{
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			redirect(base_url() . "install/");
		if ($controller->check_log->check_login() == FALSE)
			redirect(base_url() . "connexion/");
		if ($controller->check_log->check_login() == FALSE)
			$elem['profil_img'] = base_url() . 'assets/images/default-profile.png';
		else
		{
			$result = $controller->db->query("SELECT `picture` FROM `users` WHERE `login` LIKE ?",
				[$controller->session->userdata("user_login")]);
			$result = $result->result_array();
			$elem['profil_img'] = "data:image/jpeg;base64," . $result[0]["picture"];
		}

		$controller->load->view('main/header', $elem);
		if (is_array($view))
		{
			foreach ($view as $v)
				$controller->load->view($v, $data);
		}
		else if (is_string($view))
			$controller->load->view($view, $data);
		$controller->load->view('main/footer');
	}
}
