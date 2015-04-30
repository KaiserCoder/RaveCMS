<?php

namespace Rave\Library\Core\Security;

use Rave\Config\Config;

/**
 * Classe permettant de créer des cookie chiffrés
 */
class Cookie
{

	/**
	 * Méthode de création de cookies chiffrés
	 * @param string $name
	 * 	Nom du cookie
	 * @param string $value
	 * 	Valeur stockée
	 * @param int $expire
	 * 	Temps de vie du cookie
	 * @return boolean
	 * 	True en cas de succès false sinon
	 */
	public static function encrypt($name, $value, $expire)
	{
		return setcookie($name, base64_encode(mcrypt_encrypt(Config::getCookie('cypher'), Config::getCookie('key'), $value, Config::getCookie('mode'), hex2bin(Config::getCookie('iv')))), time() + $expire, null, null, false, true);
	}

	/**
	 * Méthode permettant de récupérer un cookie chiffré
	 * @param string $name
	 * 	Nom du cookie
	 * @return mixed
	 * 	Valeur stockée dans le cookie
	 */
	public static function decrypt($name)
	{
		return isset($_COOKIE[$name]) ? mcrypt_decrypt(Config::getCookie('cypher'), Config::getCookie('key'), base64_decode($_COOKIE[$name]), Config::getCookie('mode'), hex2bin(Config::getCookie('iv'))) : null;
	}

}