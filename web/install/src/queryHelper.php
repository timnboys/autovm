<?php
require_once ('config.php');
function dbConnect(){
	static $connection = null;

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

	if($connection->connect_error){
		die("Error connecting to MySQL server: " . $connection->connect_error);
	}

	return $connection;
}

function dbClose(){
	$connection = dbConnect();
	if($connection){
        $connection->close();
	}
}

function dbGet($sqlCode){
	$connection = dbConnect();
	if(!$connection) {
        return null;
    }
    $connection->set_charset('utf8');

	if(!$connection->select_db(DB_NAME)){
		return null;
	}

	$result = $connection->query($sqlCode);

	if($result === false){
		return null;
	}

	if(mysqli_num_rows($result) == 0)
	{
		return null;
	}

    if ($result->num_rows == 1){
        $record[1] = $result->fetch_assoc();
        //$record[0] = $result->fetch_assoc();
    }

    elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $record[$row["id"]] = $row;
        }
    }

	mysqli_free_result($result);

    if($connection){
        $connection->close();
    }

    return $record;
}

function dbInsert($sqlCode){
    $connection = dbConnect();
    if(!$connection) {
        return null;
    }
    $connection->set_charset('utf8');

    if(!$connection->select_db(DB_NAME)){
        return null;
    }

    $connection->query($sqlCode);

    if($connection){
        $connection->close();
    }
}

function dbSoftDelete($tableName,$rowID){
    $connection = dbConnect();
	if(!$connection){
		return null;
	}
    $connection->set_charset('utf8');

    if(!$connection->select_db(DB_NAME)){
        return null;
    }

    $sqlCode = <<<SQL
UPDATE `$tableName` SET `deleted` = '1' WHERE `$tableName`.`id` = '$rowID';
SQL;

    $connection->query($sqlCode);

    if($connection){
        $connection->close();
    }
}

function dbDelete($tableName,$rowID){
    $connection = dbConnect();
    if(!$connection){
        return null;
    }
    $connection->set_charset('utf8');

    if(!$connection->select_db(DB_NAME)){
        return null;
    }

    $sqlCode = <<<SQL
DELETE FROM `$tableName` WHERE `$tableName`.`id` = '$rowID';
SQL;

    $connection->query($sqlCode);

    if($connection){
        $connection->close();
    }
}

function dbLastID($tableName){
    $connection = dbConnect();
    if(!$connection){
        return null;
    }
    $connection->set_charset('utf8');

    $result = dbGet('SELECT MAX(id) FROM `'.$tableName.'`');

    $lastID = intval($result[1]['MAX(id)']);

    if($connection){
        $connection->close();
    }

    return $lastID;
}