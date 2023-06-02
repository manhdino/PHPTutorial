<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!defined('_INCODE')) die('Access denied...');
layout('header');


//filer data
$filter = '';
if (isGet()) {
    $body = getBody();
    //filer by status
    if (!empty($body['status'])) {
        $status = $body['status'];
        if ($status == 2) {
            $status_sql = 0;
        } else {
            $status_sql = $status;
        }
        $filter .= " WHERE status = $status_sql ";
    }

    //filter by keyword
    if (!empty($body['keywords'])) {
        $keywords = $body['keywords'];
        if (strpos($filter, 'WHERE') !== false) {
            $operator = 'AND';
        } else {
            $operator = "WHERE";
        }
        $filter .= " $operator fullname like '%$keywords%' ";
    }
}


//When the records are very large we need to limit the number of
// records --> solution: website pagniation

//The total number of records
$sql = "SELECT id FROM users" . $filter;
$totalRecords = getRows($sql);

// The number of records per page
$perPage = 3;

// Caculate the pagnification acording to the number of records
$maxPages = ceil($totalRecords / $perPage);


//Website pagniation by uing method GET
if (!empty(getBody()['page'])) {
    $page = getBody()['page'];
    if ($page < 1 || $page > $maxPages) {
        $page = 1;
    }
} else {
    $page = 1; //When you access the page on the first time
}

// Calculate offset in limit by using $page
/*
*$page = 1 -> offset = 0 = ($page - 1) * $perPage
*$page = 2 -> offset = 2
*$page = 3 -> offset = 4
*/
$offset = ($page - 1) * $perPage;
//Query to get all records from users table 
$sql = "SELECT * FROM users $filter ORDER BY createAt DESC LIMIT " . "$offset" . "," . $perPage;
$listAllUsers = getRaw($sql);

//query string with website pagniation 
$query_string = null;
if (!empty($_SERVER['QUERY_STRING'])) {
    $query_string =  $_SERVER['QUERY_STRING'];
    //  echo $query_string;
    $query_string = str_replace('module=users', '', $query_string);
    $query_string = str_replace('&page=' . $page, '', $query_string);
    $query_string = trim($query_string, '&');
    $query_string = '&' . $query_string;
    echo '<br/>';
    // echo $query_string;
}
$msg = get_flash_data('msg');
$msg_type = get_flash_data('msg_type');
?>
<div class="container">
    </hr>
    <h3>List of Users:</h3>

    <p><a href="?module=users&action=add" class="btn btn-success btn-sm">Add user</a></p>

    <form action="" method="get">
        <?php getMsg($msg, $msg_type) ?>
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="0">Status</option>
                        <option value="1" <?php echo (!empty($status) && $status == 1)
                                                ? 'selected' : false
                                            ?>>Active</option>
                        <option value="2" <?php echo (!empty($status) && $status == 2)
                                                ? 'selected' : false
                                            ?>>Disabled</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <input type="search" name="keywords" class="form-control" placeholder="Key to search.." value="<?php echo !empty($keywords) ? $keywords : false ?>" />
                <input type="hidden" name="module" value="users" />
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>


    </form>
    <table class="table table-bordere">
        <thead>
            <tr>
                <th>Stt</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Created</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($listAllUsers)) :
                $count = 0;
                foreach ($listAllUsers as $user) :
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><?php echo $user['fullname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo 'User'; ?></td>
                        <td><?php echo $user['createAt']; ?></td>
                        <td><?php echo $user['status'] == 1 ? 'Active' : 'Disabled'; ?></td>
                        <td><a href="<?php
                                        echo _WEB_HOST_ROOT . '?module=users&action=edit' . '&id=' . $user['id'];
                                        ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i></a></td>
                        <td><a href="<?php
                                        echo _WEB_HOST_ROOT . '?module=users&action=delete' . '&id=' . $user['id'];
                                        ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash-o"></i> </a></td>
                    </tr>
                <?php endforeach;
            else : ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger text-center" role="alert">
                            No user
                        </div>
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>
    <hr />
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            if ($page > 1) {
                $prevPage = $page - 1;
                echo '<li class="page-item"><a class="page-link" 
                href="' . _WEB_HOST_ROOT . '?module=users' . $query_string . '&page=' . $prevPage . '"
                 aria-label="Previous">
                 <span aria-hidden="true">&laquo;</span></a></li>';
            }
            ?>

            <?php
            $begin = $page - 2;
            if ($begin < 1) {
                $begin = 1;
            }
            $end = $page + 2;
            if ($end > $maxPages) {
                $end = $maxPages;
            }
            for ($index = $begin; $index <= $end; $index++) {
            ?>
                <li class="page-item
                <?php echo ($index == $page) ? 'active' : false ?>
                "><a class="page-link" href="
                <?php
                echo _WEB_HOST_ROOT . '?module=users' . $query_string . '&page=' . $index;
                ?>">
                        <?php echo $index; ?>
                    </a></li>
            <?php } ?>
            <?php
            if ($page < $maxPages) {
                $nextPage = $page + 1;
                echo '<li class="page-item">
                <a class="page-link" href="' . _WEB_HOST_ROOT . '?module=users' . $query_string . '&page=' . $nextPage . '" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>';
            }
            ?>

        </ul>
    </nav>
</div>

<?php

layout('footer');
