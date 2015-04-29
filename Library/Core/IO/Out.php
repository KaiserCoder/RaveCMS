<?php

namespace Rave\Library\Core\IO;

use Rave\Config\Config;

/**
 * Classe gérant la création de variables SESSION et COOKIE
 */
class Out
{

    /**
     * Méthode permettant de créer une variable de SESSION
     * @param string $name
     *  Nom de la variable de SESSION
     * @param string $value
     *  Valeur de la variable de SESSION
     */
    public static function session($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Méthode permettant de créer une variable de SESSION
     * serialisée
     * @param string $name
     *  Nom de la variable de SESSION
     * @param string $value
     *  Valeur de la variable de SESSION
     */
    public static function serializedSession($name, $value)
    {
        $_SESSION[$name] = serialize($value);
    }

    /**
     * Méthode permettant de détruire les variables
     * de SESSION
     */
    public static function sessionDestroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Méthode permettant de supprimer une variable de SESSION
     * @param string $name
     *  Nom de la variable à supprimer
     */
    public static function unsetSession($name)
    {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Méthode permettant de créer un COOKIE
     * @param string $name
     *  Nom du COOKIE
     * @param string $value
     *  Valeur du COOKIE
     * @param int $expire
     *  Durée du COOKIE
     */
    public static function cookie($name, $value, $expire)
    {
        setcookie($name, $value, time() + $expire, null, null, false, true);
    }

    /**
     * Méthode permettant de supprimer un COOKIE
     * @param string $name
     *  Nom du COOKIE à supprimer
     */
    public static function unsetCookie($name)
    {
        setcookie($name, null, 0, null, null, false, false);
    }

    /**
     * Méthode permettant l'envoi d'un mail
     * @param string $to
     *  Destinataire
     * @param string $subject
     *  Objet du mail
     * @param string $message
     *  Message
     */
    public static function mail($to, $subject, $message)
    {
        mail($to, $subject, $message);
    }

}
