<?php
if (!defined('_INCODE'))
    die('Access denied...');
if (!isLogin()) {
    redirect('?module=auth&action=login');
}
?>

<html>

<head>
    <title>Users Manager</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo _WEB_HOST_TEMPLATES; ?>/css/style.css?ver=<?php echo rand(); ?>" />
</head>

<body>

    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand">Home</a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown profile">
                            <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                Hi,Dinomanh
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item">Profile</a>
                                <a class="dropdown-item" href="<?php
                                echo _WEB_HOST_ROOT . '?module=auth&action=logout';
                                ?>">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>