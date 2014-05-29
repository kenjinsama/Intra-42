<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loader'))
{
	function loader($controller, $view, $data = NULL)
	{
		/*
		**	Verif de la config et de la connexion, redirection associé
		*/
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			redirect(base_url() . "install/");
		if ($controller->check_log->check_login() == FALSE)
			redirect(base_url() . "connexion/");

		/*
		**	Chargment img profile en fonction de l'utilisateur
		*/
		$elem = array();

		if ($controller->check_log->check_login() == FALSE)
			$elem['profil_img'] = base_url() . 'assets/images/default-profile.png';
		else
		{
			$result = $controller->db->query("SELECT `picture` FROM `users` WHERE `login` LIKE ?",
				[$controller->session->userdata("user_login")]);
			$result = $result->result_array();
			$elem['profil_img'] = "data:image/jpeg;base64," . $result[0]["picture"];
		}

		$elem['nav'] = load_nav($controller);

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

	function load_nav($controller)
	{
		$query = $controller->db->query("SELECT `id`, `name`, `dt_start`, `semestre` FROM `modules` WHERE `dt_start` <= NOW()
			ORDER BY `semestre` ASC, `dt_start` DESC");

		$modules = $query->result_array();
		$query = $controller->db->query("SELECT * FROM `user_modules` WHERE `user_id` LIKE ?", [$controller->check_log->obtain_id()]);
		$query = $query->result_array();
		foreach ($query as $data)
		{
			$i = 0;
			while (isset($modules[$i]) && $data['module_id'] != $modules[$i]['id'])
				$i++;
			if (isset($modules[$i]))
				$modules[$i]['state'] = $data['state'];
		}

		$query = $controller->db->query("SELECT `id`, `id_modules`, `name`, `dt_start` FROM `projects` WHERE `dt_start` <= NOW()
			ORDER BY `id_modules` ASC, `dt_start` DESC");
		$project = $query->result_array();
		$query = $controller->db->query("SELECT * FROM `user_projects` WHERE `user_id` LIKE ?", [$controller->check_log->obtain_id()]);
		$query = $query->result_array();
		foreach ($query as $data)
		{
			$i = 0;
			while (isset($project[$i]) && $data['project_id'] != $project[$i]['id'])
				$i++;
			if (isset($project[$i]))
				$project[$i]['state'] = $data['state'];
		}
		foreach ($project as $data)
		{
			$i = 0;
			$y = 0;
			while (isset($modules[$i]) && $data['id_modules'] != $modules[$i]['id'])
				$i++;
			if (isset($modules[$i]))
				$modules[$i]['project'][$y++] = $data;
		}
		return ($modules);
	}
}
