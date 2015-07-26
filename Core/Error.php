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
     *
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
            self::show($errorCode);
        }
    }

    /**
     * Méthode de redirection vers une page
     * d'erreur
     *
     * @param $errorCode
     */
    private static function show($errorCode)
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

    public static function header($errorCode)
    {
        switch ($errorCode) {
            case '403':
                header('HTTP/1.0 403 Forbidden');
                break;
            case '404':
                header('HTTP/1.0 404 Not Found');
                break;
            case '500':
                header('HTTP/1.0 500 Internal Server Error');
                break;
        }
    }


}
