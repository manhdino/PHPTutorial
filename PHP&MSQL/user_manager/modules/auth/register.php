<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (!defined('_INCODE')) die('Access denied...');

$data = [
    'pageTitle' => 'Register Page',
];
layout('header_login', $data);

//handle registration
if (isPost()) {
    // Validate form submission

    //get all data from register'form submission
    $body = getBody();
    // echo '<pre>';
    // print_r($body);
    // echo '</pre>';
    $errors = []; //array stored errors message

    //Validate username: 
    if (empty(trim($body['username']))) {
        $errors['username']['required'] = 'You must enter a username';
    } else {
        if (strlen(trim($body['username'])) < 5) {
            $errors['username']['min'] = 'username must be at least 5 characters long';
        }
    }
    // echo '<pre>';
    // print_r($errors);
    // echo '</pre>';

    //Validate phone number:
    if (empty(trim($body['phone_number']))) {
        $errors['phone_number']['required'] = 'You must enter a phone number';
    } else {
        if (!isPhoneNumber(trim($body['phone_number']))) {
            $errors['phone_number']['isPhone'] = 'Invalid phone number';
        }
    }

    //Validate email
    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'You must enter an email address';
    } else {
        if (!isEmail(trim($body['email']))) {
            $errors['email']['isEmail'] = 'Invalid email address';
        } else { //check if email already exists in the database
            $email = trim($body['email']);
            $sql = "SELECT id FROM users WHERE email = '$email'";
            if (getRows($sql) > 0) {
                //getRows == 0 means that the email is not in the database
                $errors['email']['exists'] = 'Email address already exists';
            }
        }
    }

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

    // Check $errors
    if (empty($errors)) {
        // No errors found

        $activeToken = sha1(uniqid() . time());
        // date_default_timezone_set('Ha_Noi');
        //  echo 'activeToken: ' . $activeToken;
        $dataInsertDB = [
            'fullname' => $body['username'],
            'phone' => $body['phone_number'],
            'email' => $body['email'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'createAt' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('users', $dataInsertDB);
        if ($insertStatus) {
            //Send link active to email just submitted
            $subject = $body['username'] . ' Please acctive your account!!!';
            $content = 'Hello ' . $body['username'] . '<br/>';
            $content .= 'I saw you have registered 
        account in our website. Please click the link below to complete your registration<br/>';

            //create a link for activation account
            $linkActive = _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $activeToken;
            $content .= "<a href='$linkActive'>Active account</a>";
            $content .= "<br />Best Regards";

            //send email 
            $sendStatus =  send_mail($body['email'], $subject, $content);
            if ($sendStatus) {
                set_flash_data('msg', 'Register successfully, please check your 
                email address to confirm your registration');
                set_flash_data('msg_type', 'success');
            } else {
                set_flash_data('msg', 'System is having problems please try again later');
                set_flash_data('msg_type', 'danger');
            }
        } else {
            set_flash_data('msg', 'System is having problems please try again later');
            set_flash_data('msg_type', 'danger');
        }
    } else {
        //Have errors
        set_flash_data('msg', 'Please double check your input');
        set_flash_data('msg_type', 'danger');
        set_flash_data('errors', $errors);

        //save the data from form registration before reload
        set_flash_data('old_data', $body);
        //reload the register page
        redirect('?module=auth&action=register');
    }
}
$msg = get_flash_data('msg');
$msg_type = get_flash_data('msg_type');
$errors = get_flash_data('errors');
$old_data = get_flash_data('old_data');
// echo '<pre>';
// print_r($old_data);
// echo '</pre>';
//echo strlen(password_hash('123456', PASSWORD_DEFAULT));
?>

<div class="row">
    <div class="col-6" style="margin:20px auto">
        <h1 class="text-center ">Register</h1>
        <?php getMsg($msg, $msg_type) ?>
        <form method="post">
            <div class="form-group">
                <label for="username">Username: </label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?php echo $old_data['username'] ?? "" ?>">
                <?php
                echo form_error('username', $errors, '<span class="error">', '</span>');
                ?>
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email..." value="<?php echo $old_data['email'] ?? "";
                                                                                                                ?>">
                <?php
                echo  form_error('email', $errors, '<span class="error">', '</span>');
                ?>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone number: </label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number..." value="<?php echo $old_data['phone_number'] ?? ""; ?>">

                <?php
                echo form_error('phone_number', $errors, '<span class="error">', '</span>');
                ?>
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password..." value="<?php echo $old_data['password'] ?? ""; ?>">
                <?php
                echo form_error('password', $errors, '<span class="error">', '</span>');
                ?>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm password: </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter the Confirm_password..." value="<?php echo $old_data['confirm_password'] ?? ""; ?>">
                <?php
                echo form_error('confirm_password', $errors, '<span class="error">', '</span>');
                ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <hr>
            <div style="display: flex;justify-content: space-between;">
                <p class="text-right"><a href="?module=auth&action=login">Already have account? Login</a></p>
            </div>
        </form>
        </form>

    </div>
</div>

<?php



layout('footer_login');
