<?php

namespace Rave\Library\Core\IO;

/**
 * Classe gérant la récupération des différentes données
 * envoyées par l'utilisateur
 */
class In
{

    /**
     * Méthode permettant de récupérer les données GET
     * nettoyées
     * @param string $get
     *  Nom de la variable GET
     * @return string
     *  La variable GET nettoyée
     */
    public static function get($get)
    {
        return filter_input(INPUT_GET, $get, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Méthode permettant de récupérer les données de
     * SESSION
     * @param string $session
     *  Nom de la variable de SESSION
     * @return string
     *  La variable de SESSION
     */
    public static function session($session)
    {
        return isset($_SESSION[$session]) ? $_SESSION[$session] : null;
    }

    /**
     * Méthode permettant de récupérer les données de
     * SESSION deserialisées
     * @param string $session
     *  Nom de la variable de SESSION
     * @return string
     *  La variable de SESSION
     */
    public static function unserializedSession($session)
    {
        return isset($_SESSION[$session]) ? unserialize($_SESSION[$session]) : null;
    }

    /**
     * Méthode permettant de récupérer un COOKIE
     * @param string $cookie
     *  Nom du COOKIE
     * @return string
     *  Contenu du COOKIE
     */
    public static function cookie($cookie)
    {
        return filter_input(INPUT_COOKIE, $cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Méthode vérifiant l'existence des variables
     * POST passées en paramètre
     * @param array|string $post
     *  Variable(s) POST
     * @return boolean
     *  Vrai si la/les variables existent
     *  faux sinon
     */
    public static function isSetPost($post)
    {
        if (is_array($post)) {
            foreach ($post as $data) {
                if (isset($_POST[$data]) === false) {
                    return false;
                }
            }

            return true;
        } else {
            return isset($_POST[$post]);
        }
    }

    /**
     * Méthode permettant de récupérer les données POST
     * nettoyées
     * @param string $post
     *  Nom de la variable POST
     * @return string
     *  La variable POST nettoyée
     */
    public static function post($post)
    {
        return filter_input(INPUT_POST, $post, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
    }

}
