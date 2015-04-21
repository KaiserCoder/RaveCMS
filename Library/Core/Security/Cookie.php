<?php

namespace Rave\Library\Core\Security;

class Cookie
{
	private static $_iv;
	private static $_key;

	const IV_SOURCE = MCRYPT_RAND;
	const ENCRYPTION_MODE = MCRYPT_MODE_CBC;
	const ENCRYPTION_CYPHER = MCRYPT_TWOFISH256;

	private function _generateKeyAndIv()
	{
		$keySize = mcrypt_module_get_algo_key_size(self::ENCRYPTION_CYPHER);
		$ivSize = mcrypt_get_iv_size(self::ENCRYPTION_CYPHER, self::ENCRYPTION_MODE);
		
		self::$_iv = mcrypt_create_iv($ivSize, self::IV_SOURCE);
		self::$_key = substr(hash('tiger192,4', uniqid()), 0, $keySize);
	}

	public static function encrypt($name, $value, $expire)
	{
		self::_generateKeyAndIv();
		setcookie($name, base64_encode(mcrypt_encrypt(self::ENCRYPTION_CYPHER, self::$_key, $value, self::ENCRYPTION_MODE, self::$_iv)), time() + $expire, null, null, false, true);
		return base64_encode(self::$_key . '_' . self::$_iv);
	}

	public static function decrypt($name, $key)
	{
		$keyAndIv = explode(base64_decode($key), '_');
		return mcrypt_decrypt(self::ENCRYPTION_CYPHER, $keyAndIv[0], base64_decode($_COOKIE[$name]), self::ENCRYPTION_MODE, $keyAndIv[1]);
	}

}