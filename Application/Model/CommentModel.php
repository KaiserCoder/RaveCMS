<?php

namespace Rave\Application\Model;

use Rave\Core\Model;

class CommentModel extends Model
{

    protected static $table = 'comment';

    protected static $primary = 'id';

    public static function selectById($id)
    {
        return self::getInstance()->query('SELECT * FROM comment WHERE id = :id', [':id' => $id]);
    }

}