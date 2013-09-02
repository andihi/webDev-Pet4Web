<?php

require_once 'util.php';

if(isset($_GET['section']))
    $section = $_GET['section'];
else
    $section ='non';

if($section == 'tryToLogIn')
{ 
    @session_start();    
    if(isset($_POST['email']) && isset($_POST['password']))
    {        
        logIn($_POST['email'],$_POST['password']);
        if(isUserLoggedIn())
        {
            header("Location: ./index.php");
            exit;
        }
        
    }
}

if(isUserLoggedIn())
{
    echo "user is logged in...";
    //TODO edit user name and pwd and so on...
}
else
{
    // show log in form with link to create new account...
    echo "<form action = './user.php?section=tryToLogIn' method='post' >";
    echo "email: <input type='text' name='email'><br />";
    echo " passwort: <input type='password' name='password'>";
    echo "<input type='submit' value ='log in' />";
    echo "</form>";
    
    echo "<a href='createNewUser.php'>Neuen account erstellen...</a>";
}

?>