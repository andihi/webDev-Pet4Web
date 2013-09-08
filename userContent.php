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