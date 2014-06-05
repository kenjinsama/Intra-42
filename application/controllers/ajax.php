<?php
// ------------ HEAD ------------ //
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
// ------------ **** ------------ //

class Ajax extends CI_Controller
{
	/**
	 * yearbook
	 */
	public function		get_uid($uid = null)
	{
		$bind = @ldap_search($this->ldap->_ldapconn, "ou=people,dc=42,dc=fr", "uid=" . $uid . "*");
		$result = ldap_get_entries($this->ldap->_ldapconn, $bind);
		foreach ($result as $value)
		{
			if (isset($value['uid'][0]))
				echo anchor(base_url().'user/profile/'.$value['uid'][0], $value['uid'][0], array('class' => 'button')) . '<BR />';
		}
	}

	/**
	 * yearbook
	 */
	public function 	get_users_order($order = 0)
	{
		$users = $this->ldap->get_all();
		$i = 0;
		foreach ($users as $user)
		{
			if (isset($user['uid'][0]))
			{
			$array[$i] = $user['uid'][0];
			$i++;
			}
		}
		if ($order == 0)
			asort($array);
		else
			arsort($array);
		foreach ($array as $value)
		{
			echo anchor(base_url().'user/profile/'.$value, $value, array('class' => 'button')) . '<BR />';
		}
	}

	/**
	 * group
	 */
	public function 	get_users_to_group($project = null, $uid = null)
	{
		$this->load->model('projects_m');
		$query = $this->projects_m->get_unregistered($project);
		$tab = array();
		foreach ($query as $data)
		{
			$tmp = substr($data['login'], 0, strlen($uid));
			if ($tmp == $uid)
				$tab[] = $data['login'];
		}
		if (sizeof($tab) < 10)
		{
			foreach ($tab as $value)
				echo '<INPUT id="'.$value.'" onClick="addUser(\''.$value.'\')" type="button" value="'.$value.'"/><BR />';
		}
	}

	/**
	 * group
	 */
	public function 	add_users_to_group($project = null, $uid = null)
	{
		$this->db->query('UPDATE `user_projects` SET `id_master` = "'.$this->session->userdata('user_id').'" WHERE project_id = "'.$project.'" AND usre_id = "'.$this->check_log->obtain_id($uid).'"');

		$this->load->model('projects_m');
		$res = $this->projects_m->get_project_group($this->session->userdata('user_id'), $project);
		foreach ($res as $value)
		{
			echo $value->id;
		}
	}

	/**
	 * group
	 */
	public function		get_project_grp_size($id)
	{
		$query = $this->db->query('SELECT `grp_size` FROM projects WHERE id="'.$id.'"');
		$res = $query->result_array();
		echo $res[0]['grp_size'];
	}
}