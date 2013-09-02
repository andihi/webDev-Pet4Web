<?php
session_start();

function logIn($email, $password)
{
    $connection = createDbConnection();    
    $sqlQuery =sprintf("SELECT id, firstname, lastname, email FROM customer where email='%s' and password ='%s'",mysql_real_escape_string($email),mysql_real_escape_string($password));    
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $query;
        die($message);
    }
    
    $num = mysql_num_rows($result);
    echo "Anzahl der zeilen: $num";
    $userInfo = mysql_fetch_array($result);
    $_SESSION['firstname'] = $userInfo['firstname'];
    $_SESSION['lastname'] = $userInfo['lastname'];
    $_SESSION['email'] = $userInfo['email'];
    $_SESSION['id'] = $userInfo['id'];
    
    //echo '<div>Vorname: $userinfo['."'firstname']</div>"
    //print("<div>Vorname: $_SESSION['firstname']</div>");
    mysql_free_result($result);
    mysql_close($connection);    
}

?>