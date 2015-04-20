<?php

namespace Rave\Library\Core;

use Rave\Core\Error;
use Rave\Core\Exception\IOException;

class Logger
{
    const NOTICE = 0;
    const WARNING = 1;
    const FATAL_ERROR = 2;
    
    private $currentLogFile;
    
    private static $_instance;
    
    private static function _getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Logger();
        }
        
        return self::$_instance;
    }
    
    public static function log($message, $priority)
    {
        switch ($priority) {
            case self::NOTICE:
                $log = time() . ' : ' . $message;
                break;
            case self::WARNING:
                $log = time() . ' WARNING : ' . $message;
                break;
            case self::FATAL_ERROR:
                $log = time() . ' FATAL ERROR : ' . $message;
                break;
        }
        
        try {
            self::_getInstance()->write($log);
        } catch (IOException $exception) {
            Error::create($exception->getMessage(), '500');
        }
    }
    
    public function write($content)
    {
        if (isset($this->currentLogFile)) {
            file_put_contents($this->currentLogFile, $content);
        } else {
            $this->currentLogFile = ROOT . '/Log/' . uniqid() . '.log';
            
            if (fopen($this->currentLogFile, 'a') === false) {
                throw new IOException('Unable to create log file');
            }
            
            $this->write($content);
        }
    }

}