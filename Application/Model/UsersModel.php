<?php

namespace Rave\Application\Model;

use Rave\Core\Model;

class UsersModel extends Model
{
	
	protected static $table = 'rave_users';
	
	protected static $primary = 'user_id';
	
}