<?php

/*
 * create user section functions
 */
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
    include 'htmlUserLoginForm.php'; // because I don't want to write html in echo""
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
}

function tryToChangeUserSettings()
{
    if(!isUserLoggedIn())
    {
        header("Location: ./index.php");
        exit;
    }   
    
    if(!isset($_POST['password1']) || !isset($_POST['password2']) )
    {
        var_dump($_POST);
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
    
    changePassword($_SESSION['email'],$password1);    
}

function passwordNotChangedMessage($reason)
{
    if(isset($reason))
        printf( "<center>
                <h1 class=\"warning\">Ihr Passwort wurde nicht geändert! </br>%s</h1>
            </center>",$reason);
    else
        printf( "<center>
                <h1 class=\"warning\">Ihr Passwort wurde nicht geändert!</h1>
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