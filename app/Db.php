<?php
class Db{
	private static $db;
	public static function init()
	{
		if(!self::$db)
		{
			try{
                self::$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            } catch (mysqli_sql_exception $e) {
                throw $e;
            }
        }
        return self::$db;
	}
}
