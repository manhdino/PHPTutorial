<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/functions.php';

$urlImg = 'https://i1-kinhdoanh.vnecdn.net/2023/06/01/Ha-Sy-Dong-jpeg-5518-1685590931.jpg?w=680&h=0&q=100&dpr=1&fit=crop&s=_99h8cEjkaN186PKwQPaFQ';

DownloadImg($urlImg, '../images');