<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use App\Database\Module\Users;
require_once '../../config.php';
require_once '../../includes/Database.php';
require_once '../../includes/Business.php';
require_once 'Users.php'; //load class Users
$user = new Users();

$listUser = $user -> get();
echo '<pre>';
print_r($listUser);
echo '</pre>';