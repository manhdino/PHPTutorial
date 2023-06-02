<?php
if (!defined('_INCODE')) die('Access denied...');
//echo "icludes/function";
function layout($layoutName = 'header', $data = [])
{
    $path = _WEB_PATH_TEMPLATES . '/' . 'layouts/' . $layoutName . '.php';
    //  echo $path;
    if (file_exists($path)) {
        require_once $path;
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'manhnguyen1238@gmail.com';                     //SMTP username
        $mail->Password   = 'zxhvpgycvvjkdqnf';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom('manhnguyen1238@gmail.com', 'Dinomanh');
        $mail->addAddress($to);     //Add a recipient             //Name is optional
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//Kiem tra method post
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

//Kiem tra method get
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

//Lay gia tri method post,get
function getBody()
{
    $bodyArr = [];
    if (isGet()) {
        if (!empty($_GET)) {
            //Xu ly chuoi truoc khi hien thi ra(bao mat)
            foreach ($_GET as $key => $val) {
                $key = strip_tags($key);
                if (is_array($val)) {
                    $bodyArr[$key] =  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] =  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    if (isPost()) {
        if (!empty($_POST)) {
            //Xu ly chuoi truoc khi hien thi ra(bao mat)
            foreach ($_POST as $key => $val) {
                $key = strip_tags($key);
                if (is_array($val)) {
                    $bodyArr[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $bodyArr;
}


//Validate email address
function isEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

//Validate integer value

function isNumberInt($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}

//Validate float value
function isNumberFloat($number, $range = [])
{
    if (!empty($range)) {
        $options = ['options' => $range];
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
    } else {
        $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    }
    return $checkNumber;
}

//Validate phone number (012xx - icludes 10 characters,begin with 0 characters )
function isPhoneNumber($phoneNumber)
{
    $checkFirstZero = false;
    if ($phoneNumber[0] == '0') {
        $checkFirstZero = true;
        $phoneNumber = substr($phoneNumber, 1); // Delete first zero in phone number
    }

    $checkNumberLast = false;
    if (isNumberInt($phoneNumber) && strlen($phoneNumber) == 9) {
        $checkNumberLast = true;
    }

    if ($checkFirstZero && $checkNumberLast) {
        return true;
    }
    return false;
}


//function create announcement error message
function getMsg($msg, $type = 'success')
{
    // echo 'type in function' . $type;
    if (!empty($msg)) {
        echo '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
    }
}

//function redirect between web pages using func header()
function redirect($url = 'index.php')
{
    header('Location: ' . $url);
    exit;
}

//function announce error for input fields in form register
function form_error($field_name, $error, $openTagHTML, $closetagHTML)
{
    return (!empty($error[$field_name]))
        ? $openTagHTML . reset($error[$field_name]) . $closetagHTML
        : "";
}

//Check Login Status
function isLogin()
{
    $checkLogin = false;
    if (get_session('login_token')) {
        $tokenLogin = get_session('login_token');
        //echo $tokenLogin;
        //check $tokenLogin exits in login_token table in database
        $sql = "SELECT userId FROM login_token WHERE token='$tokenLogin'";
        // echo $sql;
        $query_token = firstRaw($sql);
        if (!empty($query_token)) {
            $checkLogin = true;
        } else {
            remove_session('login_token');
        }
    }
    return $checkLogin;
}
