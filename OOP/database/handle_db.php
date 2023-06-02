<?php 

require_once 'config.php';
require_once 'includes/Database.php';
require_once 'includes/Business.php';

use App\Database\Database;
use App\Database\Business;

$db = new Database();

/*
$sql = "SELECT * FROM users";
$statement = $db -> query($sql,[],true);
$data = $statement ->fetchAll((PDO::FETCH_ASSOC));
echo '<pre>';
print_r($data);
echo '</pre>';
*/

/* Get all the record in the table 
$data --> Two-Dimensional Arrays
$sql = "SELECT * FROM users ORDER BY id DESC";
$data = $db -> getAllRecord($sql);
echo '<pre>';
print_r($data);
echo '</pre>';
*/

/* Get first record in the table
 * $data --> One-Dimensional Arrays
$sql = "SELECT * FROM users WHERE id = 2";
 $data = $db -> getFirstRecord($sql);
 echo '<pre>';
 print_r($data);
 echo '</pre>';
 */

/*Insert record into the table
$dataInsert=[
    'fullname' => 'manhdino3',
    'email' => 'manhnguyen124@gmail.com',
    'status' => 0,
    'created_at' => date('Y-m-d H:i:s')
];

if($db -> instertData('users',$dataInsert)){
    echo 'Insert Successfully';
}else{
    echo 'Error';
}
*/

/* Update record
$dataUpdate=[
    'fullname' => 'manhdino3',
    'email' => 'manhnguyen1241@gmail.com',
    'status' => 0,
    'updated_at' => date('Y-m-d H:i:s')
];
$condition = "id = 3";
if($db -> updateData('users',$dataUpdate,$condition)){
   echo '<br>Update successfully';
}else{
    echo 'Error';
}*/

/*Delete Record
$condition = 'id = 3';
if($db -> deleteData('users',$condition)){
    echo '<br>Delete successfully';
}else{
    echo 'Error';
}
*/

/*Get Rows
$sql = "SELECT * FROM users WHERE id >= 5";
$count = $db -> getRows($sql);
echo $count;
*/

/*Get last Id Insert
$dataInsert=[
    'fullname' => 'manhdino10',
    'email' => 'manhnguyen130@gmail.com',
    'status' => 0,
    'created_at' => date('Y-m-d H:i:s')
];

if($db -> instertData('users',$dataInsert)){
    echo 'Insert Successfully<br>';
}else{
    echo 'Error';
}

//C1: using function 
//$id = $db -> getLastInsertId();
//C2: using PDO build-in function
//$id = $db -> getPDO()->lastInsertId();
echo $id;
*/