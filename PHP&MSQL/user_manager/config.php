<?php
//File includes constants defined
const _MODULE_DEFAULT = 'home';
const _ACTION_DEFAULT = 'list';
const _INCODE = true; //Ngăn chặn truy cập trực tiếp vào file qua url



//Thiet lap host(dia chi trang chu tren website)
define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/module5/user_manager');

define('_WEB_HOST_TEMPLATES', _WEB_HOST_ROOT . '/templates');

//Thiet lap path(tren may local)
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATES', _WEB_PATH_ROOT . '/templates');

//Thiet lap ket noi DB Mysql PHP

const _HOST = 'localhost';
const _USER = 'root';
const _PASS = '';
const _DB = 'phponline';
const _DRIVER = 'mysql';
