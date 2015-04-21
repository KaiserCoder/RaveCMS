<?php

namespace Rave\Application\Model;

use Rave\Core\Model;

class UserModel extends Model
{
	
	protected static $table = 'user';
	
	protected static $primary = 'user_id';
	
}