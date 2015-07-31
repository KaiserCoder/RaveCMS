<?php

namespace Rave\Library\Core\Security;

use Rave\Config\Config;

/**
 * Classe permettant de créer des SESSION chiffrées
 */
class Session
{

    /**
     * Méthode permettant de créer une variable de SESSION
     * serialisée
     *
     * @param string $name
     *  Nom de la variable de SESSION
     * @param string $value
     *  Valeur de la variable de SESSION
     */
    public static function serialize($name, $value)
    {
        $_SESSION[$name] = base64_encode(mcrypt_encrypt(Config::getEncryption('cypher'), Config::getEncryption('key'),
            serialize($value), Config::getEncryption('mode'), hex2bin(Config::getEncryption('iv'))));
    }

    /**
     * Méthode permettant de détruire les variables
     * de SESSION
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Méthode permettant de supprimer une variable de SESSION
     *
     * @param string $name
     *  Nom de la variable à supprimer
     */
    public static function delete($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Méthode permettant de récupérer les données de
     * SESSION deserialisées
     *
     * @param string $session
     *  Nom de la variable de SESSION
     * @return string
     *  La variable de SESSION
     */
    public static function unserialize($session)
    {
        return isset($_SESSION[$session]) ? unserialize(mcrypt_decrypt(Config::getEncryption('cypher'),
            Config::getEncryption('key'), base64_decode($_SESSION[$session]), Config::getEncryption('mode'),
            hex2bin(Config::getEncryption('iv')))) : null;
    }

    /**
     * Méthode permettant de logger un utilisateur
     * en initialisant une clé de session
     *
     * @param string $name
     *  Acces de l'utilisateur
     */
    public static function login($name)
    {
        self::set($name, Config::getSession($name));
    }

    /**
     * Méthode permettant de créer une variable de SESSION
     *
     * @param string $name
     *  Nom de la variable de SESSION
     * @param string $value
     *  Valeur de la variable de SESSION
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = base64_encode(mcrypt_encrypt(Config::getEncryption('cypher'), Config::getEncryption('key'),
            $value, Config::getEncryption('mode'), hex2bin(Config::getEncryption('iv'))));
    }

    /**
     * Méthode permettant de vérifier les droits d'un
     * utilisateur
     *
     * @param string $name
     *  Acces de l'utilisateur
     * @return boolean
     *  True si valide, false sinon
     */
    public static function check($name)
    {
        return self::get($name) === Config::getSession($name);
    }

    /**
     * Méthode permettant de récupérer les données de
     * SESSION
     *
     * @param string $session
     *  Nom de la variable de SESSION
     * @return string
     *  La variable de SESSION
     */
    public static function get($session)
    {
        return isset($_SESSION[$session]) ? mcrypt_decrypt(Config::getEncryption('cypher'),
            Config::getEncryption('key'), base64_decode($_SESSION[$session]), Config::getEncryption('mode'),
            hex2bin(Config::getEncryption('iv'))) : null;
    }

}
