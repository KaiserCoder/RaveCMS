<?php

namespace Rave\Core;

use PDOException, PDO;
use Rave\Config\Config;
use Rave\Core\Database\DriverFactory;

/**
 * Super classe abstraite Model, doit être héritée par
 * tous les models nécessitants des interractions avec
 * la base de données
 */
abstract class Model
{

    /**
     * Attribut désignant la table sur laquelle le model opère
     * @var string
     *  Nom de la table
     */
    protected static $table;
    
    /**
     * Attribut désignant la clé primaire de la table
     * @var string
     *  Nom de la clé primaire
     */
    protected static $primary;
    
    /**
     * Attribut statique pour pattern Singleton
     * @var \Rave\Core\Database\Driver\SQLDriver
     * 	Driver de la base de données
     */
    private static $_driver;
    
    /**
     * Méthode accesseur utilisant le pattern Singleton
     * @return \Rave\Core\Database\Driver\DriverInterface
     * 	Driver de la base de données
     */
	protected static function _getInstance()
	{
		if (isset(self::$_driver) === false) {
			self::$_driver = DriverFactory::connect(Config::getDatabaseDriver());
		}
		
		return self::$_driver;
	}
    
    /**
     * Méthode d'insertion générique
     * @param array $rows
     *  Valeurs à inserer
     */
    public static function insert(array $rows)
    {
		$firstHalfStatement = 'INSERT INTO ' . static::$table . ' (';

		$secondHalfStatement = ') VALUES (';

		foreach ($rows as $key => $value)
		{
			$firstHalfStatement .= $key . ', ';
			$key = ':' . $key;
			$secondHalfStatement .= $key . ', ';
			stripcslashes($value);
			trim($value);
		}

		$firstHalfRequest = rtrim($firstHalfStatement, ', ');
		$secondHalfRequest = rtrim($secondHalfStatement, ', ');

		$statement = $firstHalfRequest . $secondHalfRequest . ')';

		self::_getInstance()->execute($statement, $rows);
    }

    /**
     * Méthode de selection d'une table entière générique
     * @return array
     *  Tableau d'objets
     */
    public static function selectAll()
    {
		return self::_getInstance()->query('SELECT * FROM ' . static::$table);
    }

    /**
     * Méthode générique de selection selon une valeur
     * de la clé primaire
     * @param string $primary
     *  Valeur de la clé primaire
     * @return object
     *  Objet contenant les valeurs selectionnées
     */
    public static function select($primary)
    {
		return self::_getInstance()->queryOne('SELECT * FROM ' . static::$table . ' WHERE ' . static::$primary . ' = :primary', [':primary' => $primary]);
    }

    /**
     * Méthode générique de mise à jour
     * @param array $rows
     *  Nouvelles valeurs
     * @param mixed $primary
     *  Valeur de la clé primaire
     */
    public static function update($primary, array $rows)
    {
		$statement = 'UPDATE ' . static::$table . ' SET ';

		foreach ($rows as $key => $value)
		{
			$statement .= $key . ' = :' . $key . ', ';
			stripcslashes($value);
			trim($value);
		}
            
		$request = rtrim($statement, ', ');
		$request .= ' WHERE ' . static::$primary . ' = :primary';

		$rows[':primary'] = $primary;

		self::_getInstance()->execute($request, $rows);
    }

    /**
     * Méthode générique permettant de supprimer
     * une ligne dans la base de données
     * @param string $primary
     *  Clauses de la condition WHERE
     */
    public static function delete($primary)
    {
		self::_getInstance()->execute('DELETE FROM ' . static::$table . ' WHERE ' . static::$primary . ' = :primary', [':primary' => $primary]);
    }

    /**
     * Méthode permettant de conter le nombre d'entrées
     * d'une table
     * @return int
     *  Nombre de lignes comptées
     */
    public static function count()
    {
		return self::_getInstance()->queryOne('SELECT Count(' . static::$primary . ') AS count FROM ' . static::$table)->count;
    }

}
