<?php


session_start();
//echo 'index.php' . '<br/>';
require_once 'config.php';
//import php_mailer library
require_once 'includes/php_mailer/PHPMailer.php';
require_once 'includes/php_mailer/SMTP.php';
require_once 'includes/php_mailer/Exception.php';
require_once 'includes/functions.php';
require_once 'includes/connect.php';
require_once 'includes/database.php';
require_once 'includes/session.php';

$module = _MODULE_DEFAULT;
$action = _ACTION_DEFAULT;

if (!empty($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
        // echo $module;
    }
}

if (!empty($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
        //echo $action;
    }
}
// echo $module . '<br />';
// echo $action;

$path = 'modules/' . $module . '/' . $action . '.php';
//echo '<br />';
//echo $path;
if (file_exists($path)) {
    // echo 'path exists';
    require_once $path;
} else {
    //  echo '<br />';
    //  echo 'error_action_not_found';
    require_once 'modules/errors/404.php';
}
// echo _WEB_PATH_ROOT;
