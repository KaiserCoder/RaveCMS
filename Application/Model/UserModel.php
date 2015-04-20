<?php

namespace Rave\Application\Model;

use Rave\Core\Database\Model;

class UserModel extends Model
{
	
	protected static $_table = 'user';
	
	protected static $_primary = 'user_id';
	
}