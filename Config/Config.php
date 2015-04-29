<?php

namespace Rave\Config;

use Rave\Core\Error;
use Rave\Core\Database\DriverFactory;

/**
 * Classe à modifier pour configurer les informations
 * nécessaires à l'accès à la base de données
 */
class Config
{
    
    /**
     * Attribut déterminant le mode de l'application
     * @var boolean
     *  Vrai si mode debug, faux si mode production
     */
    private static $_debug = true;
    
    /**
     * Attribut déterminant le driver de base de données
     * utilisé
     * @var string
     * 	Constante determinant le type de driver à utiliser
     */
    private static $_databaseDriver = DriverFactory::MYSQL_PDO;

    /**
     * Attribut contenant les différentes informations
     * nécessaires à la connexion à la base de données
     * @var array
     *  Liste des infos de connexion
     */
    private static $_database = [
        'host'     => 'localhost',
        'database' => 'database',
        'login'    => 'root',
        'password' => 'root'
    ];

    /**
     * Attribut contenant les différentes informations
     * nécessaires au Router
     * @var array
     *  Liste contenant le nom du controller et de la
     *  méthode à appeller par defaut
     */
    private static $_router = [
        'controller' => 'Main',
        'method'     => 'index'
    ];
    
    /**
     * Attribut contenant les différentes pages d'erreur
     * @var array
     *  Liste contenant les nom des controllers
     *  pour chaque type d'erreur
     */
    private static $_error = [
        '500' => 'error/internal-server-error',
        '404' => 'error/not-found',
        '403' => 'error/forbidden'
    ];

    /**
     * Grain de sel pour la fonction de Hashage
     * @var string
     *  Grain de sel
     */
    private static $_databaseSeed = 'f6z5e4f62s1d32v1d653d4g65d4f32v1';
    
    /**
     * Valeurs nécessaires au chiffrement des cookies
     * @var array
     * 	Clé, iv encodé en hexa, cypher et mode de chiffrement
     */
    private static $_cookie = [
    	'mode'   => MCRYPT_MODE_CBC,
    	'cypher' => MCRYPT_RIJNDAEL_256,
    	'key'    => 'c70911343b8a3b94f5780ce5e65d2daa',
    	'iv'     => 'dc4931bc7b44eebb62e4e5e590a54461401b8ea9d9b39546d7aab4b44cdfe3c6'
    ];
    
    /**
     * Méthode accesseur
     * @return boolean
     *  Attribut debug
     */
    public static function isDebug()
    {
        return self::$_debug;
    }
    
    /**
     * Méthode accesseur
     * @return string
     * 	Nom du driver pour la base de données
     */
    public static function getDatabaseDriver()
    {
    	return self::$_databaseDriver;
    }

    /**
     * Méthode accesseur
     * @param string
     *  Attribut databases
     * @return string
     *  Valeur associée à la clé
     */
    public static function getDatabase($key)
    {
    	if (isset(self::$_database[$key])) {
        	return self::$_database[$key];
    	} else {
    		Error::create('Unknown database key ' . $key, '500');
    	}
    }

    /**
     * Méthode accesseur
     * @param string $key
     *  Clé de la liste
     * @return string
     *  Valeur associée à la clé
     */
    public static function getRouter($key)
    {
        return self::$_router[$key];
    }
    
    /**
     * Méthode accesseur
     * @param string $key
     *  Clé de la liste
     * @return string
     *  Valeur associée à la clé
     */
    public static function getError($key)
    {
    	if (isset(self::$_error[$key])) {
    		return self::$_error[$key];
    	} else {
    		Error::create('Unknown error key ' . $key, '404');
    	}
    }

    /**
     * Méthode accesseur
     * @return string
     *  Grain de sel
     */
    public static function getDatabaseSeed()
    {
        return self::$_databaseSeed;
    }

	/**
	 * Méthode accesseur
	 * @return mixed
	 * 	Entrée demandée
	 * @param string
	 * 	Clé du tableau cookie
	 */
    public static function getCookie($key)
    {
    	return self::$_cookie[$key];
    }

}
