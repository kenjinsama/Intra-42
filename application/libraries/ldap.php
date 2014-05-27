<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class ldap
{

	private				$_ldapconn;

	public function		__construct()
	{
		if (!defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/custom_config.php'))
		{
			if (!file_exists($file_path = APPPATH.'config/custom_config.php'))
			{
				show_error('The configuration file custom_config.php does not exist.');
			}
		}

		include($file_path);
		$this->_ldapconn = ldap_connect("ldap.42.fr")
			or die("Could not connect to LDAP server.<BR />");

		if (!ldap_set_option($this->_ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3))
			show_error('Failed to set protocol version to 3<BR />');
		$bind = @ldap_bind($this->_ldapconn, 'uid=' .  $_G_LOGIN . ',ou=2013,ou=people,dc=42,dc=fr', $_G_MDP);
		if (!$bind)
			show_error('Failed to bind<BR />');
	}

	public function		log($uid, $pwd)
	{
		$bind = @ldap_bind($this->_ldapconn, 'uid=' . $uid . ',ou=2013,ou=people,dc=42,dc=fr', $pwd);
		return $bind;
	}

	public function		get_all()
	{
		$bind = @ldap_search($this->_ldapconn, "ou=people,dc=42,dc=fr", "uid=*");
		$result = ldap_get_entries($this->_ldapconn, $bind);
		return $result;
	}

	public function		get_uid($uid)
	{
		$bind = @ldap_search($this->_ldapconn, "ou=people,dc=42,dc=fr", "uid=" . $uid . "*");
		$result = ldap_get_entries($this->_ldapconn, $bind);
		return $result;
	}
}
