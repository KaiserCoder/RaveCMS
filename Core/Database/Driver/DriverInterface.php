<?php

namespace Rave\Core\Database\Driver;

interface DriverInterface {
	
    public static function query($statement, array $values = []);
    
	public static function queryOne($statement, array $value = []);
    
    public static function execute($statement, array $values = []);

}
