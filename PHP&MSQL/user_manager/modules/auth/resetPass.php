<?php
if (!defined('_INCODE')) die('Access denied...');
$data = [
    'pageTitle' => 'Reset Page',
];
layout('header_login', $data);
echo '<div class="container text-center" > <br />';
$token = getBody()['token'];
//compare token current with token already saved in database
if (!empty($token)) {
    //query $token vs forgotToken in users table
    $sql = "SELECT id,fullname,email FROM users WHERE forgotToken='$token'";
    $query_forgot_token = firstRaw($sql);
    if (!empty($query_forgot_token)) {
        $userId = $query_forgot_token['id'];
        $email = $query_forgot_token['email'];
        $userName = $query_forgot_token['fullname'];
        if (isPost()) {
            $body = getBody();
            //Validate password
            if (empty(trim($body['password']))) {
                $errors['password']['required'] = 'You must enter a password';
            } else {
                if (strlen(trim($body['password']))  < 8) {
                    $errors['password']['min'] = 'Password must be at least 8 characters long';
                }
            }

            // Validate confirm password
            if (empty(trim($body['confirm_password']))) {
                $errors['confirm_password']['required'] = 'You must enter a confirm password';
            } else {
                if (trim($body['confirm_password']) != trim($body['password'])) {
                    $errors['confirm_password']['match'] = 'Confirm password must exactly match with the password';
                }
            }
            if (empty($errors)) {
                //Update password
                $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'updateAt' => date('Y-m-d H:i:s'),
                    'forgotToken' => null
                ];
                $updateStatus = update('users', $dataUpdate, "id='$userId'");
                if ($updateStatus) {
                    set_flash_data('msg', 'Change password successfully');
                    set_flash_data('msg_type', 'success');

                    //Send email notification changed password successfully
                    $subject = 'Changed password successfully';
                    $content = 'Congratulations ' . $userName . '!!<br/>';
                    $content .= 'Your password has been changed.<br/>';

                    send_mail($email, $subject, $content);
                    redirect('?module=auth&action=login');
                } else {
                    set_flash_data('msg', 'Change password failed');
                    set_flash_data('msg_type', 'danger');
                    redirect("?module=auth&action=resetPass&token='$token'");
                }
            } else {
                //Have errors
                set_flash_data('msg', 'Please double check your input');
                set_flash_data('msg_type', 'danger');
                set_flash_data('errors', $errors);
            }
        }

        $msg = get_flash_data('msg');
        $msg_type = get_flash_data('msg_type');
        $errors = get_flash_data('errors');

?>

        <div class="row text-left">
            <div class="col-6" style="margin:20px auto">
                <h1 class="text-center ">Reset Password</h1>
                <?php echo getMsg($msg, $msg_type) ?>
                <form method="post">
                    <div class="form-group">
                        <label for="password">New password: </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
                        <?php
                        echo form_error('password', $errors, '<span class="error">', '</span>');
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm the new password: </label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password...">
                        <?php
                        echo form_error('confirm_password', $errors, '<span class="error">', '</span>');
                        ?>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token ?>"></input>
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>

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
    } else {
        getMsg('Token was not match with the forgotToken in users table', 'danger');
    }
} else {
    getMsg('Token is not exists or out of date!!!', 'danger');
}

//if true then delete token current and change field status = 1
echo '</div>';
layout('footer_login');
