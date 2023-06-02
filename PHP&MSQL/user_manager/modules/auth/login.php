<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (!defined('_INCODE')) die('Access denied...');

$data = [
    'pageTitle' => 'Login Page',
];
layout('header_login', $data);

// Check session login status before logging in
// Used for user when login is successful and out, but later access web page 
// no need to login again
if (isLogin()) {
    redirect('?module=users');
}
$msg = get_flash_data('msg');
$msg_type = get_flash_data('msg_type');

if (isPost()) {
    $body = getBody();
    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        // echo '<pre>';
        // print_r($body);
        // echo '</pre>';

        //Check login :
        $email = $body['email'];
        $password = $body['password'];
        // echo $email . '<br />';
        // echo $password;

        //Query get user's password saved in database according to email from login form

        $sql = "SELECT id,password FROM users WHERE email = '$email'";
        $user_query = firstRaw($sql);
        // echo '<pre>';
        // print_r($user_query);
        // echo '</pre>';
        if (!empty($user_query)) {
            $passwordHash = $user_query['password'];
            if (password_verify($password, $passwordHash)) {
                //table login_token save history login
                // Create token login in table login_token in database
                $user_id = $user_query['id']; //get user_id from table login_token in database
                $tokenLogin = sha1(uniqid() . time());
                echo 'token_login:' . $tokenLogin;
                $data_login_token = [
                    'userId' => $user_id,
                    'token' => $tokenLogin,
                    'createAt' => date('Y-m-d H:i:s')
                ];
                //insert $data_login_token to table login_token
                $insertTokenStatus = insert('login_token', $data_login_token);
                if ($insertTokenStatus) {
                    //save login_token in session
                    set_session('login_token', $tokenLogin);
                    //redirect back to list users page
                    redirect('?module=users');
                } else {
                    set_flash_data('msg', 'Error System, You cannot login right now');
                    set_flash_data('msg_type', 'danger');
                    // redirect('?module=auth&action=login');
                }
            } else {
                set_flash_data('msg', 'Wrong password');
                set_flash_data('msg_type', 'danger');
                // redirect('?module=auth&action=login');
            }
        } else {
            set_flash_data('msg', 'Email is not exist in the system');
            set_flash_data('msg_type', 'danger');
            // redirect('?module=auth&action=login');
        }
    } else {
        set_flash_data('msg', 'Please enter your email and password');
        set_flash_data('msg_type', 'danger');
        //redirect('?module=auth&action=login');
    }

    redirect('?module=auth&action=login');
}


//echo '<br/>Testing in here...';
// $session = set_session('login', 'Dinomanh');
// var_dump($session);
//remove_session('login');
// echo get_session('login');

//set_flash_data('msg', 'Login successful');
//echo get_flash_data('msg');

// $send = send_mail('manhdeptroai2001@gmail.com', 'Test email', 'Noi dung email');
// if ($send) {
//     echo 'Email sent successfully';
// } else {
//     echo 'Email not sent';
// }

// $body = getBody();
// echo '<pre>';
// print_r($body);
// echo '</pre>';
// echo 'id = ' . getBody()['id'];


//validate email and password
// $checkEmail = isEmail('manhnguyen@gmail.com');
// $checkNumber = isNumberInt(20, ['min_range' => 1, 'max_range' => 20]);
// $checkNumberFloat = isNumberFloat(23, ['min_range' => 1, 'max_range' => 20]);
// var_dump($checkEmail);
// var_dump($checkNumber);
// var_dump($checkNumberFloat);

//encode password
/**
 * md5,sha1 password fix for everytime reload website
 *   --> not safe -> solution : using function  password_hash() -> create a new password after reload website

 */
// $password = '12345';
// $passwordMd5 = md5($password);
// $passwordSha1 = sha1($password);
// echo '<br/>Md5 pass:' . $passwordMd5;
// echo '<br/>Sha1 pass:' . $passwordSha1;
// $passwordHash = password_hash($password, PASSWORD_DEFAULT);
// echo '<br/>Password hash:' . $passwordHash;

//passwordHash will saved on the field 'password' in the database
// $passwordHash = '$2y$10$naekepGecqhA1fOa22CynOwybsCrJ4zcVm6/csR/GFPDtS4GL4mJy';
// $checkPassword = password_verify('12345', $passwordHash);
// var_dump($checkPassword);
/**
 * When login password after input from form login will compare 
 * with the passwordHash stored in the database by using function password_verify
 */

?>

<div class="row">
    <div class="col-6" style="margin:20px auto">
        <h1 class="text-center ">Login</h1>
        <?php
        getMsg($msg, $msg_type);
        ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <hr>
            <div style="display: flex;justify-content: space-between;">
                <p><a href="?module=auth&action=forgotPass">Forgot password?</a></p>
                <p class="text-right"><a href="?module=auth&action=register">Register account</a></p>
            </div>
        </form>
        </form>

    </div>
</div>

<?php



layout('footer_login');
