<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class Ldap extends		CI_Model
{

	private				$_ldapconn;

	public function		__construct()
	{
		if (current_url() == site_url("install") || strstr(current_url(), site_url("connexion")) || current_url() == site_url("install/validate"))
		{
			$this->_ldapconn = ldap_connect("ldap.42.fr");
			if (!ldap_set_option($this->_ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3))
				show_error('Failed to set protocol version to 3<BR />');
			return ;
		}
		if (!file_exists(__DIR__ . "/../config/custom_config.php"))
			redirect(base_url() . "install");
		if ($this->check_log->check_login() == FALSE && current_url() != site_url("connexion/login"))
			redirect(base_url() . "connexion");

		$this->_ldapconn = ldap_connect("ldap.42.fr")
			or die("Could not connect to LDAP server.<BR />");

		if (!ldap_set_option($this->_ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3))
			show_error('Failed to set protocol version to 3<BR />');
		if (!$this->session->userdata("user_login"))
			show_error('wtf...<BR />');

		$bind = @ldap_bind($this->_ldapconn, 'uid=' . $this->session->userdata("user_login") . ',ou=2013,ou=people,dc=42,dc=fr', $this->session->userdata("user_pass"));
		if (!$bind)
			show_error('Failed to bind<BR />');
	}

/*
**	log() est utilisé pour la connexion user,
**	elle permet de se connecter et acceder au ldap en fonction des droits de l'utilisateur
*/
	public function		log($uid, $pwd)
	{
		$bind = @ldap_bind($this->_ldapconn, 'uid=' . $uid . ',ou=2013,ou=people,dc=42,dc=fr', $pwd);
		return ($bind);
	}

/*
**	get_all() renvoie toute les info user
*/
	public function		get_all()
	{
		$bind = @ldap_search($this->_ldapconn, "ou=people,dc=42,dc=fr", "uid=*");
		$result = ldap_get_entries($this->_ldapconn, $bind);
		return ($result);
	}

/*
**	get_uid($uid) renvoie un tableau de toute les infos des users ayant un uid commençant par la valeur de $uid
**	Exemple : get_uid("ds") renvoie un tableau des infos de 'dsousa', 'dsissoko', 'dseng', 'dsan' ...
*/
	public function		get_uid($uid)
	{
		$bind = @ldap_search($this->_ldapconn, "ou=people,dc=42,dc=fr", "uid=" . $uid . "*");
		$result = ldap_get_entries($this->_ldapconn, $bind);
		return ($result);
	}

/*
**	get_user_info($uid) renvoie un tableau de toute les infos du user tel que uid = $uid
**	si il n'y a pas de resultat ou plus d'un resultat get_user_info renvoi NULL
**	Exemple : get_uid("dsousa") renvoie un tableau des infos de 'dsousa'
*/
	public function		get_user_info($uid)
	{
		$bind = @ldap_search($this->_ldapconn, "ou=people,dc=42,dc=fr", "uid=" . $uid);
		$result = ldap_get_entries($this->_ldapconn, $bind);
		if ($result["count"] == 1)
			return ($result);
		else
			return (NULL);
	}

/*
**	get_cn($uid) renvoie le cn du user tel que uid = $uid
**	si il n'y a pas de resultat get_cn renvoi NULL
**	Exemple : get_uid("dsousa") renvoie "Dany SOUSA"
*/
	public function		get_cn($uid)
	{
		$tbl = $this::get_user_info($uid);

		if ($tbl == NULL)
			return (NULL);
		return ($tbl[0]["cn"][0]);
	}

/*
**	get_img($uid) renvoie l'image profil en base64 du user tel que uid = $uid
**	si il n'y a pas de resultat get_img renvoi NULL
*/
	public function		get_img($uid)
	{
		$tbl = $this::get_user_info($uid);

		if ($tbl == NULL)
			return (NULL);
		return (base64_encode($tbl[0]["picture"][0]));
	}
}
