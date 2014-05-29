<?php
// ------------ HEAD ------------ //
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
// ------------ **** ------------ //

class ldap
{
	private static $_ldapcon;
/*
**	log() est utilisé pour la connexion user,
**	elle permet de se connecter et acceder au ldap en fonction des droits de l'utilisateur
*/

	public function		log($uid, $pwd)
	{
		self::$_ldapcon = ldap_connect("ldap.42.fr")
			or die("Could not connect to LDAP server.<BR />");
		$this->_ldapcon = self::$_ldapcon;
		if (!ldap_set_option(self::$_ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3))
			show_error('Failed to set protocol version to 3<BR />');
		$bind = @ldap_bind(self::$_ldapcon, 'uid=' . $uid . ',ou=2013,ou=people,dc=42,dc=fr', $pwd);
		return ($bind);
	}

/*
**	get_all() renvoie toute les info user
*/
	public function		get_all()
	{
		$bind = @ldap_search(self::$_ldapcon, "ou=people,dc=42,dc=fr", "uid=*");
		$result = ldap_get_entries(self::$_ldapcon, $bind);
		return ($result);
	}

/*
**	get_uid($uid) renvoie un tableau de toute les infos des users ayant un uid commençant par la valeur de $uid
**	Exemple : get_uid("ds") renvoie un tableau des infos de 'dsousa', 'dsissoko', 'dseng', 'dsan' ...
*/
	public function		get_uid($uid)
	{
		$bind = @ldap_search(self::$_ldapcon, "ou=people,dc=42,dc=fr", "uid=" . $uid . "*");
		$result = ldap_get_entries(self::$_ldapcon, $bind);
		return ($result);
	}

/*
**	get_user_info($uid) renvoie un tableau de toute les infos du user tel que uid = $uid
**	si il n'y a pas de resultat ou plus d'un resultat get_user_info renvoi NULL
**	Exemple : get_uid("dsousa") renvoie un tableau des infos de 'dsousa'
*/
	public function		get_user_info($uid)
	{
		$bind = @ldap_search(self::$_ldapcon, "ou=people,dc=42,dc=fr", "uid=" . $uid);
		$result = ldap_get_entries(self::$_ldapcon, $bind);
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