<?php
//Include main config file
include './config.php';
//Include main functions files
include './models/DB.class.php';
include './models/UsersModel.class.php';
include './models/PresentsModel.class.php';
include './models/MoneyModel.class.php';
include './models/BonusModel.class.php';
include './classes/Login.class.php';
include './classes/Game.class.php';

//Start session
session_start();
//Set charset
header('Content-Type: text/html; charset=UTF8');

// If debug mode is enabled
if(DEBUG_MODE){
    error_reporting(E_ALL);
}

//Enable buffer
ob_start();

$login = new Login();

if(isset($_POST['login']) && isset($_POST['pass']))
    $login->doLogin();

if(isset($_GET['logout']) && $_GET['logout'] == 'true')
    $login->doLogout();
//
//echo '<pre>';
//var_dump($login);
//die;

switch($login->is_logged)
{
    case true:
        if(isset($_GET['class']))
            $class_name = $_GET['class'];

        if(class_exists($class_name)) {
            new $class_name();
        }
        else
            include './view/404.html';

        break;

    //Auth form
    case false:
        include './view/auth/auth_form.html';
        break;

    default:
        include './view/404.html';
        break;
}



$content = ob_get_contents();
ob_end_clean();

//Include main view
include './view/index.html';
?>