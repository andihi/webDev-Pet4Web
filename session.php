<?php
session_start();
require 'dbconnection.php';

function logIn($email, $password)
{
    $connection = createDbConnection();    
    $sqlQuery =sprintf("SELECT kundID, vorname, nachname, email FROM kunde where email='%s' and passwort ='%s'",mysql_real_escape_string($email),mysql_real_escape_string($password));    
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $query;
        die($message);
    }
    
    $userInfo = mysql_fetch_array($result);
    $_SESSION['firstname'] = $userInfo['vorname'];
    $_SESSION['lastname'] = $userInfo['nachname'];
    $_SESSION['email'] = $userInfo['email'];
    $_SESSION['id'] = $userInfo['kundID'];
    
    
    mysql_free_result($result);
    mysql_close($connection);    
}

?>