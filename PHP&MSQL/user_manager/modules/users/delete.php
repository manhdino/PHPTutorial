<?php
if (!defined('_INCODE')) die('Access denied...');

$body = getBody();
if (!empty($body['id'])) {
    $userId = $body['id'];
    $sql = "SELECT id FROM users WHERE id = $userId";
    $userDetailRows = getRows($sql);
    //Delete  user info
    if ($userDetailRows > 0) {
        //Delete login_token info
        $deleteToken = delete('login_token', "userId=$userId");
        if ($deleteToken) { //delete login_token successfully
            $deleteUser = delete('users', "id=$userId");
            if ($deleteUser) {
                set_flash_data('msg', 'Delete user successfully');
                set_flash_data('msg_type', 'success');
            } else {
                set_flash_data('msg', 'Delete user failed');
                set_flash_data('msg_type', 'danger');
            }
        } else {
            set_flash_data('msg', 'Delete login token failed');
            set_flash_data('msg_type', 'danger');
        }
    } else {
        set_flash_data('msg', 'No user found');
        set_flash_data('msg_type', 'danger');
    }
} else {
    set_flash_data('msg', 'Page not found');
    set_flash_data('msg_type', 'danger');
}

redirect('?module=users');
