<?php

/*
 * create user section functions
 */

function createNewUser()
{
    if(isUserLoggedIn())
    {
        echo '<h3>Sie sind bereits eingelogged!';
        return;
    }
    
    include 'htmlCreateUserAccount.php';
   
}

function tryToCreateNewAccount()
{   
    $email = getP('email');
    $password = getP('password1');
    $firstname = getP('firstname');
    $surename = getP('surename');
    
    if( !isset($firstname) || strlen($firstname) <=0)
    {
        invalidInput('Ihr Vorname ist zu kurz.');
        return;
    }
    
    if( !isset($surename) || strlen($surename) <=0)
    {
        invalidInput('Ihr Nachname ist zu kurz.');
        return;
    }
    
    if( !isset($email) || strlen($email) <=0)
    {
        invalidInput('Ihre E-Mail-Adresse ist ungültig');
        return;
    }
    
    if(  !isset($password) || strlen($password) < 3)
    {
        invalidInput('Ihr Passwort sollte mindestens 3 Zeichen lang sein.');
        return;
    }
    
    $connection = createDbConnection();
    $r = mysql_query(sprintf("SELECT count(*) FROM customer WHERE email ='%s'",mysql_real_escape_string($email)),$connection);
    $count = intval(mysql_result($r,0));
    
    if($count > 0)
    {
        invalidInput("Ein Account mit der E-Mail $email ist bereits vorhanden.");
        mysql_close($connection);
        return;
    }
    
    mysql_query(sprintf("INSERT INTO customer(firstname,lastname,email) VALUES('%s', '%s', '%s')",mysql_real_escape_string($firstname),mysql_real_escape_string($surename),mysql_real_escape_string($email)),$connection);    
    mysql_close($connection);
    changePassword($email,$password);
    logIn($email,$password);       
}

function invalidInput($text)
{
    if(isset($text))
        printf( "<center>
                <h1 class=\"warning\">Es konnte kein Benutzer angelegt werden!</br>%s</h1>
            </center>",$text);
    else
        printf( "<center>
                <h1 class=\"warning\">Es konnte kein Benutzer angelegt werden!</h1>
            </center>");
}

function tryToLogIn()
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

function editUserData()
{
}

function userLogIn()
{
    include 'htmlUserLoginForm.php';
}

function userLogOut()
{
    destroySession();
    header("Location: ./index.php");
    exit;
}

function changeUserSettings()
{
    include 'htmlUserChangeSettings.php';
    echo '<form onsubmit="return checkPassword();" id="changeSettingsForm" action="./user.php?section=tryToChangeSettings" method="post">
	<section>
        <div>
            <label for="firstname">Vorname</label>
            <input name="firstname" type="text" maxlength="50" value="'.$_SESSION['firstname'].'"/>
        </div>
        <div>
            <label for="surename">Nachname</label>
            <input name="surename" type="text" maxlength="50" value="'.$_SESSION['lastname'].'"/>
        </div>
        <div>
            <label for="email">Email</label>
            <input name="email" type="text" value="'. $_SESSION['email'].'"/>
        </div>
		<div id="passwordContainer">
			<label for="password1" >Neues Passwort eingeben</label>
			<input id="password1" type="password" name="password1"  />
            <input id="password2" type="password" name="password2"  />
		</div>
	</section>
	
	<input type="submit" value="change settings" id="submit" />
</form> ';
}

function tryToChangeUserSettings()
{
    if(!isUserLoggedIn())
    {
        header("Location: ./index.php");
        exit;
    }   
    
    $email = getP('email');
    $firstname = getP('firstname');
    $surename = getP('surename');
    
    if( !isset($firstname) || strlen($firstname) <=0)
    {
        invalidInput('Ihr Vorname ist zu kurz.');
        return;
    }
    
    if( !isset($surename) || strlen($surename) <=0)
    {
        invalidInput('Ihr Nachname ist zu kurz.');
        return;
    }
    
    if( !isset($email) || strlen($email) <=0)
    {
        invalidInput('Ihre E-Mail-Adresse ist ungültig');
        return;
    }
    
    if(!isset($_POST['password1']) || !isset($_POST['password2']) )
    {       
        passwordNotChangedMessage('Es wurden nicht beide Passwörter eingegeben!');
        return;
    }
    
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    
    if($password1 != $password2)
    {
        passwordNotChangedMessage('Die eingegebenen Passwörter stimmen nicht überein.');
        return;
    }
    
    if(strlen($password1) <3) // Dieser Fehlerfall wird nur am server aufgefangen
    {
        passwordNotChangedMessage("Das Passwort solle midestens 3 Zeichen lang sein.");
        return;
    }    
    $connection = createDbConnection();        
    $r = mysql_query(sprintf("SELECT count(*) FROM customer WHERE email ='%s'",mysql_real_escape_string($email)),$connection);
    $count = intval(mysql_result($r,0));
    
    if($count > 0)
    {
        invalidInput("Ein Account mit der E-Mail $email ist bereits vorhanden.");
        mysql_close($connection);
        return;
    }
    
    mysql_query(sprintf("UPDATE customer SET
    firstname='%s', lastname='%s', email='%s' WHERE ID =%d",mysql_real_escape_string($firstname),mysql_real_escape_string($surename),mysql_real_escape_string($email),$_SESSION['id']),$connection);
    
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $surename;
    $_SESSION['email'] = $email;
    
    changePassword($email,$password1);    
}

function passwordNotChangedMessage($reason)
{
    if(isset($reason))
        printf( "<center>
                <h1 class=\"warning\">Ihre Benutzerdaten wurde nicht geändert! </br>%s</h1>
            </center>",$reason);
    else
        printf( "<center>
                <h1 class=\"warning\">Ihre Benutzerdaten wurde nicht geändert!</h1>
            </center>");
        
}

/*
 * body:
 * if we come from user.php then $section is set otherwise false
 */
if(!isset($section))
{
    header("Location: ./index.php");
    exit;
}

switch($section)
{
    case 'tryToLogIn':
            tryToLogIn();
        break;
    case 'createNewUser':
        createNewUser();
        break;
    case 'tryToCreateNewAccount':
        tryToCreateNewAccount();
        break;
    case 'login':
            userLogIn();
        break;
    case 'changeSettings':
            changeUserSettings();
        break;
    case 'tryToChangeSettings':       
            tryToChangeUserSettings();
        break;
    case 'logout':        
    default:
            if(isUserLoggedIn())
                userLogOut();
            else
                userLogIn();
        break;
}