<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (!defined('_INCODE')) die('Access denied...');
$data = [
    'pageTitle' => 'Forgot Password Page',
];
layout('header_login', $data);

if (isLogin()) {
    redirect('?module=users');
}

if (isPost()) {
    $body = getBody();
    if (!empty($body['email'])) {
        $email = $body['email'];
        //query $email in users table to get id
        $sql = "SELECT id,fullname FROM users WHERE email = '$email'";
        $query_user = firstRaw($sql);
        if (!empty($query_user)) {
            $userId = $query_user['id'];

            //Creae forgot token
            $forgotToken = sha1(uniqid() . time());
            $dataUpdate = [
                'forgotToken' => $forgotToken,
                'updateAt' => date('Y-m-d H:i:s')
            ];
            $updateStatus = update('users', $dataUpdate, "id='$userId'");
            if ($updateStatus) {
                //Send email link to change password
                $subject = 'Requeset restore password';
                $content = 'Hi ' . $query_user['fullname'] . '<br />';
                $content .= "We just had a request from you to reset your password <br />";
                $content .= "Please click on the following link in the below to reset your password!";

                //Create link reset password
                $linkReset = _WEB_HOST_ROOT . '?module=auth&action=resetPass&token=' . $forgotToken;
                $content .= "<br />";
                $content .= "<a href='$linkReset'>Reset Password</a>";
                $content .= "<br />Best Regards";

                //send link to gmail
                $sentStatus = send_mail($email, $subject, $content);
                if ($sentStatus) {
                    set_flash_data('msg', 'Send successfully!<br /> Please
                    check email address to know what to do next!');
                    set_flash_data('msg_type', 'success');
                } else {
                    set_flash_data('msg', 'Send failed!<br /> Please
                    try again');
                    set_flash_data('msg_type', 'danger');
                }
            } else {
                set_flash_data('msg', 'Error system You cannot use this feature');
                set_flash_data('msg_type', 'danger');
            }
        } else {
            set_flash_data('msg', 'Email address is not exits in the database');
            set_flash_data('msg_type', 'danger');
        }
    } else {
        set_flash_data('msg', 'Please enter your email address');
        set_flash_data('msg_type', 'danger');
    }
    //redirect('?module=auth&action=forgotPass');
}
$msg = get_flash_data('msg');
$msg_type = get_flash_data('msg_type');

?>

<div class="row">
    <div class="col-6" style="margin:20px auto">
        <h1 class="text-center ">Forgot Password</h1>
        <span style="color: red;align-items:center;">Enter your email and we'll send you
            a link to reset your password.</span>
        <?php
        getMsg($msg, $msg_type);
        ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
            <hr>
            <div style="display: flex;justify-content: space-between;">
                <p><a href="?module=auth&action=login">Back to Login</a></p>
                <p class="text-right"><a href="?module=auth&action=register">Register account</a></p>
            </div>
        </form>
        </form>

    </div>
</div>

<?php



layout('footer_login');
