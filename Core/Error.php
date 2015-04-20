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
     * @param string $error
     *  Message d'erreur
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
     */
    private static function _show($errorCode)
    {
        switch ($errorCode) {
            case '403':
                header('HTTP/1.0 403 Forbidden');
                header('Location: ' . Config::getError('403'));
                break;
            case '404':
                header('HTTP/1.0 404 Not Found');
                header('Location: ' . Config::getError('404'));
                break;
            case '500':
                header('HTTP/1.0 500 Internal Server Error');
                header('Location: ' . Config::getError('500'));
                break;
        }
        die();
    }

}
