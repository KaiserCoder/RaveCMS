<?php

namespace Rave\Core;

/**
 * Classe d'autoload
 */
class Autoloader
{

    /**
     * Méthode appelée lors de l'autoload d'une classe
     * @param string $className
     *  Nom de la classe à inclure
     */
    private static function _autoload($className)
    {
        if (strpos($className, 'Rave') === 0) {
            require_once ROOT . '/' . str_replace('\\', '/', str_replace('Rave', null, $className)) . '.php';
        }
    }
    
    /**
     * Méthode permettant d'initialiser l'autoloader
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, '_autoload']);
    }

}
