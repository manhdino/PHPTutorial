<?php
if (!defined('_INCODE')) die('Access denied...');
echo 'This is logout page';

if (isLogin()) {
    $token = get_session('login_token');
    //delete token from login_token ta
    delete('login_token', "token='$token'");
    remove_session($token);
    redirect('?module=auth&action=login');
}
