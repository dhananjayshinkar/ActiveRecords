<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('DATABASE', 'dps48');
define('USERNAME', 'dps48');
define('PASSWORD', 'guYTqxyD1');
define('CONNECTION', 'sql1.njit.edu');


/**
* 
*/
class dbConn
{
	protected static $db;

	function __construct()
	{
		try {
            // assign PDO object to db variable
            self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        	}

        catch (PDOException $e)
        	{
            //Output error - would normally log this to error file rather than output to user.
            echo "Connection Error: " . $e->getMessage();
        	}
	}


	public static function getConnection() 
	{
        if (!self::$db) 
        {
            new dbConn();
        }
        return self::$db;
    }
}


class collection 
{
    
    static public function findAll() {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }

    static public function findOne($id) {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet[0];
    }
}


class accounts extends collection {
    protected static $modelName = 'account';
}
class todos extends collection {
    protected static $modelName = 'todo';
}


//$records = accounts::findAll();
//print_r($records);

$records = accounts::findOne(2);
print_r($records);
?>