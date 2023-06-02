<?php

/**
 * Connect PHP with MySql by using PDO(PHP Data Object)
 * Why use PDO? --> PDO will work on 12 different database systems.
 * So, if you have to switch your project to use another database, PDO makes the process easy.
 */

//Connect with MySQL: 
try {
    $__HOST = '127.0.0.1';
    $__DB = 'webcompany';
    $__USER = 'root';
    $__PASS = 'mysql';
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Show Error in catch if ran to Error
    ];
    $con = new PDO(
        'mysql:dbname=' . $__DB . ';host=' . $__HOST,
        $__USER,
        $__PASS,
        $options
    );
} catch (Exception $e) {
    $err = $e->getMessage();
}

//Insert data into MySQL:
//C1: using bindParam
$stmt = $con->prepare('INSERT INTO users (username, password, create_at,
status) values (:username, :password, :create_at, :status)');
$username = 'dinomanh.web';
$password = '123456';
$now = date('Y-m-d H:i:s');
$status = 1;
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':create_at', $now);
$stmt->bindParam(':status', $status);
$stmt->execute();

//C2: using Array - Should use
$stmt = $con->prepare('INSERT INTO users (username, password, create_at,status) values (:username, :password, :create_at, :status)');
$data = array(
    'username' => 'dinomanh.web',
    'password' => '123456',
    'create_at' =>
    date('Y-m-d H:i:s'),
    'status' => 1
);
$stmt->execute($data);

//Update data in MySQL:
$stmt = $con->prepare("UPDATE users SET username='friendntt10' WHERE id=?");
$id = [8];
$stmt->execute($id);

//Delete data in MySQL:
$stmt = $con->prepare("DELETE FROM users WHERE id=?");
$id = [8];
$stmt->execute($id);

//Get data(Query) in MySQL
$stmt = $con->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); //get all the record 

$stmt = $con->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetch(PDO::FETCH_ASSOC); //get the first recored matched

//Get ID of The Last Inserted Record
$stmt = $con->prepare('INSERT INTO users (username,
password, create_at, status) values (:username, :password,
:create_at, :status)');
$data = array(
    'username' => 'dinomanh.web',
    'password' => '123456',
    'create_at' => date('Y-m-d H:i:s'),
    'status' => 1
);
$stmt->execute($data); //Chạy câu lệnh SQL
echo $con->lastInsertId();

/*Constants:
* PDO::FETCH_BOTH (default):returns an array indexed by both column name and 0-indexed column number as returned in your result set
• PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set
• PDO::FETCH_NUM: returns an array indexed by column number as returned in your result set, starting at column 0
*/