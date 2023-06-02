<?php
if (!defined('_INCODE')) die('Access denied...');
layout('header_login');
echo '<div class="container text-center" > <br />';
$token = getBody()['token'];
//echo $token;

//compare token current with token already saved in database
if (!empty($token)) {
    //query check token current with token already saved in database
    $sql = "SELECT id ,fullname , email FROM users WHERE activeToken = '$token'";
    // echo $sql;
    // $token_query = getRows($sql);
    // if ($token_query == 1) {
    //     echo 'Token current exactly matches with token in database';
    // } else {
    //     echo 'Token current does not exactly match with token in database';
    // }

    $token_query = firstRaw($sql);
    if (!empty($token_query)) {
        $user_id = $token_query['id'];
        // echo $user_id;
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null,
            'updateAt' => date('Y-m-d H:i:s'),
        ];
        $updateStatus =  update('users', $dataUpdate, 'id=' . $user_id);
        if ($updateStatus == 1) {
            set_flash_data('msg', 'Your account activated successfully! 
            You can now login with your account.');
            set_flash_data('msg_type', 'success');

            //Create link login will be sent in email address
            $login_link = _WEB_HOST_ROOT . '?module=auth&action=login';
            //Send email congratulations active account success
            $subject = 'Your account activated successfully';
            $content = 'Congratulations ' . $token_query['fullname'] . '<br/>';
            $content .= 'Your account activated successfully,
            you can login in the link below<br/>';
            $content .= $login_link;
            $content .= '<br/>Thanks for registering';
            send_mail($token_query['email'], $subject, $content);
        } else {
            set_flash_data('msg', 'Something went wrong.Please try contact with administrator to fix the problem.');
            set_flash_data('msg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    } else {
        echo '<div class="alert alert-danger" role="alert">Link is not exists or out of date!!!</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Token is not exists or out of date!!!</div>';
}
//if true then delete token current and change field status = 1
echo '</div>';
layout('footer_login');
