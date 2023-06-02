<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use App\Database\Module\ProductCategory;
require_once '../../config.php';
require_once '../../includes/Database.php';
require_once '../../includes/Business.php';
require_once 'ProductCategory.php'; //load class Users
$productCategory = new ProductCategory();
$dataInsert = [
    'fullname' => 'Dinomanh'
];
$statusInsert = $productCategory -> insert($dataInsert);
if($statusInsert){
    $listProductCategory = $productCategory->get();
echo '<pre>';
print_r($listProductCategory);
echo '</pre>';
}