<?php

namespace Rave\Library\Core\Security;

use Rave\Config\Config;

/**
 * Classe contenant différentes méthodes
 * liées à la des chaines de caractères
 */
class String
{

	/**
	 * Méthode de hash à utiliser avant une insertion
	 * de mot de passe dans la base de données
	 * @param string $data
	 *  Chaine de caractères à crypter
	 * @return string
	 *  Résultat du hash
	 */
	public static function hash($data)
	{
		return hash('whirlpool', $data . Config::getDatabaseSeed(), false);
	}

	/**
	 * Méthode permettant de nettoyer une chaine de caractères
	 * afin d'éviter les failles XSS et autres
	 * @param string $data
	 *  Chaine de caractères à nettoyer
	 * @return string
	 *  Chaine de caractères nettoyée
	 */
	public static function clean($data)
	{
		$trimmedData = trim($data);
		$escapedData = stripslashes($trimmedData);
		$cleanedData = htmlspecialchars($escapedData);
		return $cleanedData;
	}

	/**
	 * Méthode vérifiant si la chaine de caractères passée
	 * en paramètre est un email
	 * @param string $email
	 *  Chaine de caractère à vérifier
	 * @return boolean
	 *  Vrai si la chaine est un email
	 */
	public static function isEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}
	
}