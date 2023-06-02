<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!defined('_INCODE')) die('Access denied...');

try {
    if (class_exists('PDO')) {
        $dsn = _DRIVER . ':dbname=' . _DB . ';host=' . _HOST;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8: tiếng việt
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //đẩy lỗi vào ngoại lệ khi truy vấn
        ];
        // echo $dsn;
        $conn = new PDO($dsn, _USER, _PASS, $options);
        //  echo '<br/>' . 'connect successfully';
        // var_dump($conn);
    }
} catch (Exception $e) {
    require_once('modules/errors/404_DB.php');
    die();
}
