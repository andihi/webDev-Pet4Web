<?php

function logIn($email, $password)
{
    $connection = createDbConnection();    
    $sqlQuery =sprintf("SELECT id, firstname, lastname, email, isAdmin FROM customer where email='%s' and password ='%s'",mysql_real_escape_string($email),mysql_real_escape_string(md5($password)));    
    $result = mysql_query($sqlQuery, $connection);
    
    if (!$result)
    {
        $message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
        $message .= 'Gesamte Abfrage: ' . $query;
        die($message);
    }
    
    $num = mysql_num_rows($result);
    
    if($num != 1)
        $loggedIn = false;
    else
        $loggedIn = true;
    
    $userInfo = mysql_fetch_array($result);
    $_SESSION['firstname'] = $userInfo['firstname'];
    $_SESSION['lastname'] = $userInfo['lastname'];
    $_SESSION['email'] = $userInfo['email'];
    $_SESSION['id'] = $userInfo['id'];   
    $_SESSION['isAdmin'] = $userInfo['isAdmin'];
    
    //echo '<div>Vorname: $userinfo['."'firstname']</div>"
    //print("<div>Vorname: $_SESSION['firstname']</div>");
    mysql_free_result($result);
    mysql_close($connection);    
}

function changePassword($email,$password, $connection= null)
{
    $isMyOwnConnection =true;
    if(!isset($connection))
    {
        $isMyOwnConnection = false;
        $connection = createDbConnection();
    }
    
    $sqlQuery =sprintf("UPDATE customer SET password ='%s' where email='%s'",mysql_real_escape_string(md5($password)),mysql_real_escape_string($email));    
    mysql_query($sqlQuery, $connection);
    
    if($isMyOwnConnection)
        mysql_close($connection);        
}

function destroySession()
{
    $_SESSION = array();
    
    if (ini_get("session.use_cookies"))
    {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"],
        $params["domain"], $params["secure"], $params["httponly"] );
    }
    
    session_destroy();   
}

/*
function setSessionCookieOnClient()
{
    if (ini_get("session.use_cookies"))
    {       
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() + 600, $params["path"],
        $params["domain"], $params["secure"], $params["httponly"] );
    }
}
*/

function isUserLoggedIn()
{
    return isset($_SESSION['id']);
}

function isUserAdmin()
{    
    return isUserLoggedIn() && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
}

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

function getP($name)
{
    if(isset($_POST[$name]))
        return $_POST[$name];
    else
        return null;
}

?>