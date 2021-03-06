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
     *
     * @var array
     *  Paramètres passés dans l'URL
     */
    private static $params;

    /**
     * Méthode permettant la gestion des routes
     *
     * @param string $get
     *  Url contenant le nom du controleur et la méthode
     *  à appeler ainsi que les possibles paramètres
     *  de cette méthode
     */
    public static function get($get)
    {
        self::$params = explode('/', $get);

        $controllerClass = self::getController();

        $controllerMethod = self::getMethod();

        $controllerFile = ROOT . '/Application/Controller/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            Error::create('Erreur controller inexistant', '404');
        }

        $class = new $controllerClass;

        self::callMethod($class, $controllerMethod);
    }

    /**
     * Méthode retournant le controleur appelé dans
     * l'url
     *
     * @return string
     *  Retourne le nom du controleur
     */
    private static function getController()
    {
        if (isset(self::$params[self::CONTROLLER_KEY]) && empty(self::$params[self::CONTROLLER_KEY]) === false) {
            $controller = ucfirst(self::$params[self::CONTROLLER_KEY]);
        } else {
            $controller = Config::getRouter('controller');
        }

        unset(self::$params[self::CONTROLLER_KEY]);

        return str_replace('-', '_', $controller);
    }

    /**
     * Méthode permettant de déterminer la méthode
     * à appeler
     *
     * @return string
     *  Retourne le nom de la méthode
     */
    private static function getMethod()
    {
        if (isset(self::$params[self::METHOD_KEY]) && empty(self::$params[self::METHOD_KEY]) === false) {
            $action = self::$params[self::METHOD_KEY];
        } else {
            $action = Config::getRouter('method');
        }

        unset(self::$params[self::METHOD_KEY]);

        return str_replace('-', '_', $action);
    }

    /**
     * Méthode permettant d'appeler la méthode du controleur
     * et de lui passer les possibles paramètres
     *
     * @param Controller $class
     *  Controleur appelé
     * @param string     $action
     *  Méthode appelée
     */
    private static function callMethod($class, $action)
    {
        if (method_exists($class, $action) && is_callable([$class, $action])) {
            call_user_func_array([$class, $action], self::$params);
        } else {
            Error::create('Erreur methode controller inexistante', '404');
        }
    }

}