<?php

namespace Rave\Library\Core;

/**
 * Classe permettant la redirection exceptionelle ou l'envoie
 * de headers HTTP
 */
class Http
{

    /**
     * Méthode permettant de créer un header HTTP
     * @param string $header
     *  Header à envoyer
     */
    public static function header($header)
    {
        header($header);
    }

    /**
     * Méthode permettant de rediriger l'utilisateur
     * vers la page passée en paramètre
     * @param string $page
     *  Nom du controleur à appeler
     */
    public static function redirect($page)
    {
        header('Location: ' . $page);
    }

}
