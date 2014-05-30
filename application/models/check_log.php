<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //


/*
**	En attente de la connexion
*/

class check_log extends		CI_Model
{
	public function		check_login()
	{
		if ($this->session->userdata('logged_in') && $this->session->userdata('user_login') && $this->session->userdata('user_pass'))
		{
			if ($this->session->userdata('logged_in') == TRUE)
				return (TRUE);
			else
				return (FALSE);
		}
		else
			return (FALSE);
	}

	/*
	**	Retourne l'id de l'utilisateur connecté ou NULL si aucun utilisateur est connecté obtain_id renvoi NULL
	*/
	public function		obtain_id()
	{
		if ($this::check_login() == FALSE)
			return (NULL);
		$query = $this->db->query("SELECT `id` FROM `users` WHERE `login` LIKE ?", [$this->session->userdata('user_login')]);
		$query = $query->result_array();

		return ($query[0]['id']);
	}

	public function		check_log_admin()
	{
		// if ($this::check_login() === TRUE)
		// {
		// 	$query = $this->db->query("SELECT COUNT(id) FROM `admin` WHERE `uid` LIKE ?",
		// 		[$this->session->userdata('user_login')]);
		// 	$query = $query->result_array();
		// 	if ($query[0]["COUNT(id)"])
		// 		return TRUE;
		// }
		// return FALSE;
		return (TRUE);
	}

	public function		is_admin($uid)
	{
		// if ($this::check_login() === TRUE)
		// {
		// 	$query = $this->db->query("SELECT COUNT(id) FROM `admin` WHERE `uid` LIKE ?",
		// 		[$uid]);
		// 	$query = $query->result_array();
		// 	if ($query[0]["COUNT(id)"])
		// 		return TRUE;
		// }
		// return FALSE;
		return (TRUE);
	}
}