<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!defined('_INCODE')) die('Access denied...');
$data = [
    'pageTitle' => 'Edit User',
];
layout('header_login', $data);

//When click edit from list page, id of user will sent to edit_user page
//edit_user will check if user_id exists to query user info in database
//Get old data from list page
$body = getBody();
if (!empty($body['id'])) {
    $userId = $body['id'];
    //Check userId is exists or not
    //if not redirect to list page, otherwise get data info from list page
    $sql = "SELECT * FROM users WHERE id = $userId";
    $userDetail = firstRaw($sql);
    if (!empty($userDetail)) {
        set_flash_data('userDetail', $userDetail);
    } else {
        redirect('?module=users');
    }
} else {
    echo "ELSE ERROR";
    redirect('?module=users');
}



//Edit user information
if (isPost()) {
    // Validate form submission
    //get all data from register'form submission
    $body = getBody();
    $errors = []; //array stored errors message

    //Validate username: 
    if (empty(trim($body['username']))) {
        $errors['username']['required'] = 'You must enter a username';
    } else {
        if (strlen(trim($body['username'])) < 5) {
            $errors['username']['min'] = 'username must be at least 5 characters long';
        }
    }
    //Validate phone number:
    if (empty(trim($body['phone_number']))) {
        $errors['phone_number']['required'] = 'You must enter a phone number';
    } else {
        if (!isPhoneNumber(trim($body['phone_number']))) {
            $errors['phone_number']['isPhone'] = 'Invalid phone number';
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

    // Check $errors
    if (empty($errors)) {
        // If no errors found, update user info in database
        $dataUpdateDB = [
            'fullname' => $body['username'],
            'phone' => $body['phone_number'],
            'status' => $body['status'],
            'updateAt' => date('Y-m-d H:i:s'),
        ];
        $condition = "id=$userId";
        if (!empty(trim($body['password']))) {
            $dataUpdateDB['password'] = password_hash($body['password'], PASSWORD_DEFAULT);
        }
        $updateStatus = update('users', $dataUpdateDB, $condition);
        if ($updateStatus) {
            set_flash_data('msg', 'Update successfully!');
            set_flash_data('msg_type', 'success');
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
    }
    //reload the edit page
    redirect('?module=users&action=edit&id=' . $userId);
}
$msg = get_flash_data('msg');
$msg_type = get_flash_data('msg_type');
$errors = get_flash_data('errors');
$userDetail = get_flash_data('userDetail');
$old_data = get_flash_data('old_data');
if (!empty($userDetail)) {
    $old_data = $userDetail;
}
?>
<div class="container">
    <hr />
    <h3><?php echo $data['pageTitle'] ?></h3>
    <?php getMsg($msg, $msg_type) ?>
    <form action="" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="username">Username: </label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?php echo $old_data['fullname'] ?? ""; ?>">

                    <?php
                    echo form_error('username', $errors, '<span class="error">', '</span>');
                    ?>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone number: </label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number..." value="<?php echo $old_data['phone'] ?? ""; ?>">

                    <?php
                    echo form_error('phone_number', $errors, '<span class="error">', '</span>');
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password..." value="<?php echo $old_data['password'] ?? ""; ?>">
                    <?php
                    echo form_error('password', $errors, '<span class="error">', '</span>');
                    ?>
                </div>
                <div class="form-group">
                    <label for="status">Status: </label>
                    <select class="form-control" id="status" name="status">
                        <option value="0" <?php
                                            if (!empty($old_data['status']))

                                                echo $old_data['status'] == 0 ? 'selected' : false
                                            ?>>Disabled</option>
                        <option value="1" <?php
                                            if (!empty($old_data['status']))
                                                echo $old_data['status'] == 1 ? 'selected' : false
                                            ?>>Active</option>
                    </select>
                </div>
            </div>
        </div>
        <hr />
        <input type="hidden" name="id" value="<?php echo $userId; ?>" />
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="?module=users" class="btn btn-success">Back</a>
    </form>
</div>

<?php

layout('footer');
