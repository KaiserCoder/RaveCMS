<?php

namespace Rave\Core\Exception;

class MIMEException extends \Exception
{
	const ERROR_CODE = 3;

	public function __construct($message)
	{
		parent::__construct($message, self::ERROR_CODE);
	}

}