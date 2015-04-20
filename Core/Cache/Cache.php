<?php

namespace Rave\Core\Cache;

abstract class Cache
{ 
    protected static $_instance;
    
    private static function _getInstance()
    {
        if (isset(self::$_instance) === false) {
            self::$_instance = new \Memcache();
        }
        
        return self::$_instance;
    }
    
    public static function set($key, $value, $lifeTime = 0)
    {
        self::_getInstance()->set($key, $value, $lifeTime);
    }

    public static function delete($key)
    {
        self::_getInstance()->delete($key);
    }

    public static function update($key, $value, $lifeTime = 0)
    {
        self::_getInstance()->update($key, $value, $lifeTime);
    }

}
