<?php

function createDbConnection()
{
    $connection = mysql_connect("127.0.0.1:3306","pet4web","pet4web");
    if(!$connection)
    {
        die('SQL-Serververbindung schlug fehl: '.mysql_error());
    }
    
    mysql_select_db("pet4web") or die('Unable to select database. See: '.mysql_error());
    
    return $connection;
    // please close connection after usage like:
    // mysql_close($connetion);
}

?>