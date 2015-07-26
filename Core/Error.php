<?php

namespace Rave\Core;

use Rave\Config\Config;

/**
 * Classe chargée de gérer les erreurs et redirections 404
 */
class Error
{

    /**
     * Méthode permettant de créer une erreur
     * Redirection vers une page d'erreur si
     * l'application est en mode production
     * @param string $errorMessage
     *  Message d'erreur
     * @param string $errorCode
     *  Code d'erreur
     */
    public static function create($errorMessage, $errorCode = '404')
    {
        if (Config::isDebug()) {
            die($errorMessage);
        } else {
            self::_show($errorCode);
        }
    }

    /**
     * Méthode de redirection vers une page
     * d'erreur
     * @param $errorCode
     */
    private static function _show($errorCode)
    {
        switch ($errorCode) {
            case '403':
                header('Location: ' . WEB_ROOT . Config::getError('403'));
                break;
            case '404':
                header('Location: ' . WEB_ROOT . Config::getError('404'));
                break;
            case '500':
                header('Location: ' . WEB_ROOT . Config::getError('500'));
                break;
        }
        die();
    }

}
