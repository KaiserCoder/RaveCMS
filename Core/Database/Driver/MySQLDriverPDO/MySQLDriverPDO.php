<?php

namespace Rave\Core\Database\Driver\MySQLDriverPDO;

use PDO;
use PDOException;
use Rave\Config\Config;
use Rave\Core\Database\Driver\DriverInterface;
use Rave\Core\Error;

class MySQLDriverPDO implements DriverInterface
{
    const FETCH_STYLE = PDO::FETCH_OBJ;
    private static $_instance;

    public static function query($statement, array $values = [])
    {
        return self::queryDatabase($statement, $values, false);
    }

    private static function queryDatabase($statement, array $values, $unique)
    {
        try {
            $sql = self::getInstance()->prepare($statement);
            $sql->execute($values);
            if ($unique === true) {
                return $sql->fetch(self::FETCH_STYLE);
            } else {
                return $sql->fetchAll(self::FETCH_STYLE);
            }
        } catch (PDOException $pdoException) {
            Error::create($pdoException->getMessage(), '500');
        }
    }

    private static function getInstance()
    {
        if (isset(self::$_instance) === false) {
            try {
                self::$_instance = new PDO('mysql:dbname=' . Config::getDatabase('database') . ';host=' . Config::getDatabase('host'),
                    Config::getDatabase('login'), Config::getDatabase('password'));
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $pdoException) {
                Error::create($pdoException->getMessage(), '500');
            }
        }

        return self::$_instance;
    }

    public static function queryOne($statement, array $values = [])
    {
        return self::queryDatabase($statement, $values, true);
    }

    public static function execute($statement, array $values = [])
    {
        try {
            $sql = self::getInstance()->prepare($statement);
            $sql->execute($values);
        } catch (PDOException $pdoException) {
            Error::create($pdoException->getMessage(), '500');
        }
    }

}
