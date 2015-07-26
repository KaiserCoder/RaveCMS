<?php

namespace Rave\Core;

use Rave\Config\Config;

/**
 * Classe chargée de gérer les routes de l'application
 */
class Router
{

    /**
     * Constante définissant la clé du controleur
     * appelé dans la liste des paramètres
     */
    const CONTROLLER_KEY = 0;

    /**
     * Constante définissant la clé de la méthode
     * appelée dans la liste des paramètres
     */
    const METHOD_KEY = 1;

    /**
     * Attribut contenant les paramètres passés
     * dans l'URL
     * @var array
     *  Paramètres passés dans l'URL
     */
    private static $_params;

    /**
     * Méthode permettant la gestion des routes
     * @param string $get
     *  Url contenant le nom du controleur et la méthode
     *  à appeler ainsi que les possibles paramètres
     *  de cette méthode
     */
    public static function get($get)
    {
        self::$_params = explode('/', $get);

        $controllerClass = self::_getController();

        $controllerMethod = self::_getMethod();

        $controllerFile = ROOT . '/Application/Controller/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            Error::create('Erreur controller inexistant', '404');
        }

        $class = new $controllerClass;

        self::_callMethod($class, $controllerMethod);
    }

    /**
     * Méthode retournant le controleur appelé dans
     * l'url
     * @return string
     *  Retourne le nom du controleur
     */
    private static function _getController()
    {
        if (isset(self::$_params[self::CONTROLLER_KEY]) && empty(self::$_params[self::CONTROLLER_KEY]) === false) {
            $controller = ucfirst(self::$_params[self::CONTROLLER_KEY]);
        } else {
            $controller = Config::getRouter('controller');
        }

        unset(self::$_params[self::CONTROLLER_KEY]);

        return str_replace('-', '_', $controller);
    }

    /**
     * Méthode permettant de déterminer la méthode
     * à appeler
     * @return string
     *  Retourne le nom de la méthode
     */
    private static function _getMethod()
    {
        if (isset(self::$_params[self::METHOD_KEY]) && empty(self::$_params[self::METHOD_KEY]) === false) {
            $action = self::$_params[self::METHOD_KEY];
        } else {
            $action = Config::getRouter('method');
        }

        unset(self::$_params[self::METHOD_KEY]);

        return str_replace('-', '_', $action);
    }

    /**
     * Méthode permettant d'appeler la méthode du controleur
     * et de lui passer les possibles paramètres
     * @param Controller $class
     *  Controleur appelé
     * @param string $action
     *  Méthode appelée
     */
    private static function _callMethod($class, $action)
    {
        if (method_exists($class, $action) && is_callable([$class, $action])) {
            call_user_func_array([$class, $action], self::$_params);
        } else {
            Error::create('Erreur methode controller inexistante', '404');
        }
    }

}